<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use App\Models\Paket;
use App\Models\Transaksi;
use App\Services\TransaksiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\TransaksiExport;

class TransaksiController extends Controller
{
    protected TransaksiService $service;

    public function __construct(TransaksiService $service)
    {
        $this->service = $service;
    }

    /**
     * Resolve lokasi_id aktif untuk user yang sedang login.
     *
     * Priority:
     * 1. $fallbackFromRequest  — eksplisit dari request (superadmin / step lokasi wizard)
     * 2. session active_lokasi_id — dipilih user saat step lokasi
     * 3. penugasanAktif pertama — kalau admin hanya punya 1 lokasi aktif
     *
     * Return null kalau tidak ada konteks lokasi sama sekali.
     */
    private function getLokasiId(?int $fallbackFromRequest = null): ?int
    {
        if ($fallbackFromRequest) {
            return $fallbackFromRequest;
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->isSuperAdmin()) {
            return session('active_lokasi_id');
        }

        $penugasanAktif = $user->penugasanAktif;

        // Admin hanya punya 1 lokasi aktif — pakai langsung
        if ($penugasanAktif->count() === 1) {
            return $penugasanAktif->first()->lokasi_id;
        }

        // Admin punya 2+ lokasi aktif — butuh session
        return session('active_lokasi_id');
    }

    /**
     * Set lokasi aktif ke session.
     * Dipanggil dari step lokasi di wizard transaksi.
     */
    public function setLokasiAktif(Request $request)
    {
        $request->validate([
            'lokasi_id' => ['required', 'exists:lokasis,id'],
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Validasi: admin hanya boleh set lokasi yang memang ditugaskan ke dia
        if (!$user->isSuperAdmin()) {
            $valid = $user->penugasanAktif()
                          ->where('lokasi_id', $request->lokasi_id)
                          ->exists();

            if (!$valid) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lokasi tidak valid untuk akun ini.',
                ], 403);
            }
        }

        session(['active_lokasi_id' => (int) $request->lokasi_id]);

        return response()->json(['success' => true]);
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'tanggal_mulai', 'tanggal_akhir', 'lokasi']);

        $transaksi = Transaksi::with([
                'member',
                'paket.lokasi',
                'bukuMasuk.buku',
                'bukuKeluar.buku',
            ])
            ->when($filters['search'] ?? null, function ($q, $search) {
                $q->where(function ($q) use ($search) {
                    $q->whereHas('member', fn($m) =>
                            $m->where('nama', 'ilike', "%{$search}%")
                            ->orWhere('no_telp', 'ilike', "%{$search}%"))
                    ->orWhereHas('bukuMasuk.buku', fn($b) => $b->where('judul', 'ilike', "%{$search}%"))
                    ->orWhereHas('bukuKeluar.buku', fn($b) => $b->where('judul', 'ilike', "%{$search}%"));
                });
            })
            ->when($filters['lokasi'] ?? null, fn($q, $lokasi) => $q->where('lokasi_snapshot', $lokasi))
            ->when(
                ($filters['tanggal_mulai'] ?? null) || ($filters['tanggal_akhir'] ?? null),
                function ($q) use ($filters) {
                    if ($filters['tanggal_mulai'] && $filters['tanggal_akhir']) {
                        $q->whereBetween('tanggal_tukar', [
                            $filters['tanggal_mulai'] . ' 00:00:00',
                            $filters['tanggal_akhir'] . ' 23:59:59'
                        ]);
                    } elseif ($filters['tanggal_mulai']) {
                        $q->whereDate('tanggal_tukar', '>=', $filters['tanggal_mulai']);
                    } elseif ($filters['tanggal_akhir']) {
                        $q->whereDate('tanggal_tukar', '<=', $filters['tanggal_akhir']);
                    }
                }
            )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $transaksiHariIni   = Transaksi::whereDate('tanggal_tukar', today())->count();
        $transaksiMingguIni = Transaksi::whereBetween('tanggal_tukar', [now()->startOfWeek(), now()])->count();
        $transaksiBulanIni  = Transaksi::whereMonth('tanggal_tukar', now()->month)->count();

        $paketAktif = Paket::aktif()->with('lokasi')->get();

        $lokasiId  = $this->getLokasiId();
        $paketUser = $lokasiId
            ? Paket::aktif()->where('lokasi_id', $lokasiId)->first()
            : null;

        $lokasiList = Transaksi::whereNotNull('lokasi_snapshot')
            ->distinct()
            ->orderBy('lokasi_snapshot')
            ->pluck('lokasi_snapshot')
            ->filter()
            ->values();

        $authUser = Auth::user();
        $lokasiPilihan = $authUser->isSuperAdmin()
            ? Lokasi::aktif()->orderBy('nama_lokasi')->get()
            : Lokasi::whereIn('id',
                $authUser->penugasanAktif()->pluck('lokasi_id')
            )->orderBy('nama_lokasi')->get();

        $activeLokasiId = $this->getLokasiId();
        $oldestTransaksi = (object) [
            'tanggal_tukar' => \Carbon\Carbon::parse(
                Transaksi::oldest('tanggal_tukar')->value('tanggal_tukar') ?? now()
            )->startOfYear()
        ];

        return view('admin.transaksi.index', compact(
            'transaksi',
            'transaksiHariIni',
            'transaksiMingguIni',
            'transaksiBulanIni',
            'paketAktif',
            'paketUser',
            'lokasiList',
            'lokasiPilihan',
            'activeLokasiId',
            'oldestTransaksi',
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member.nama'        => 'required|string|max:255',
            'member.no_telp'     => 'required|string|max:15',
            'buku_masuk.judul'   => 'required|string|max:255',
            'buku_masuk.pengarang' => 'required|string|max:255',
            'buku_keluar_id'     => 'required|exists:buku_eksemplars,id',
            'paket_masuk_id'     => 'required|exists:pakets,id',
            'paket_keluar_id'    => 'required|exists:pakets,id',
        ]);

        try {
            $this->service->simpan(array_merge(
                $request->all(),
                [
                    'user_id'   => Auth::id(),
                    'lokasi_id' => $this->getLokasiId(),
                ]
            ));

            return response()->json(['success' => true, 'message' => 'Transaksi berhasil disimpan.']);

        } catch (\RuntimeException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem.',
            ], 500);
        }
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'member.nama'    => 'required|string|max:255',
            'member.no_telp' => 'required|string|max:15',
            'buku_keluar_id' => 'required|exists:buku_eksemplars,id',
        ]);

        try {
            $this->service->update($id, $request->all());

            return response()->json(['success' => true, 'message' => 'Transaksi berhasil diperbarui.']);

        } catch (\RuntimeException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem.',
            ], 500);
        }
    }

    public function destroy(int $id)
    {
        $this->service->delete($id);

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus.');
    }

    public function show(int $id)
    {
        $transaksi = Transaksi::with([
                'member',
                'paket.lokasi',
                'bukuMasuk.buku',
                'bukuKeluar.buku',
                'user',
            ])
            ->findOrFail($id);

        return response()->json([
            ...$transaksi->toArray(),
            'lokasi' => $transaksi->lokasi_snapshot,
        ]);
    }

    public function cariMember(Request $request)
    {
        $results = $this->service->cariMember($request->keyword ?? '');
        return response()->json($results);
    }

    public function simpanMember(Request $request)
    {
        $request->validate([
            'nama'    => 'required|string|max:255',
            'no_telp' => 'required|string|max:15',
        ]);

        $member = $this->service->simpanAtauUpdateMember($request->all());
        return response()->json($member);
    }

    public function cariBukuIsbn(Request $request)
    {
        $request->validate(['isbn' => 'required|string']);
        $lokasiId = $this->getLokasiId($request->integer('lokasi_id') ?: null);

        $buku = $this->service->cariBukuByIsbn($request->isbn, $lokasiId);
        return response()->json($buku);
    }

    public function cariBukuJudul(Request $request)
    {
        $lokasiId = $this->getLokasiId($request->integer('lokasi_id') ?: null);

        $hasil = $this->service->cariBukuByJudul($request->keyword ?? '', $lokasiId);
        return response()->json($hasil);
    }

    public function bukuByPaket(Request $request)
    {
        $lokasiId = $this->getLokasiId($request->integer('lokasi_id') ?: null);

        $eksemplars = $this->service->bukuByLokasi($lokasiId);
        return response()->json($eksemplars);
    }

    public function paketAktif(Request $request)
    {
        $lokasiId = $this->getLokasiId($request->integer('lokasi_id') ?: null);

        $pakets = Paket::aktif()
            ->when($lokasiId, fn($q) => $q->where('lokasi_id', $lokasiId))
            ->with('lokasi')
            ->get();

        return response()->json($pakets);
    }

    public function cariBukuMeta(Request $request)
    {
        $request->validate(['isbn' => 'required|string']);

        $buku = \App\Models\Buku::where('isbn', $request->isbn)
            ->first(['judul', 'pengarang', 'penerbit', 'kategori',
                     'tahun_terbit', 'tempat_terbit', 'isbn']);

        return response()->json($buku);
    }

    public function cariBukuMasukJudul(Request $request)
    {
        $keyword = $request->input('keyword', '');

        $hasil = \App\Models\Buku::where(function ($q) use ($keyword) {
                $lower = mb_strtolower($keyword);
                $q->whereRaw('LOWER(judul) LIKE ?', ['%' . $lower . '%'])
                  ->orWhereRaw('LOWER(pengarang) LIKE ?', ['%' . $lower . '%'])
                  ->orWhereRaw('LOWER(COALESCE(isbn, \'\')) LIKE ?', ['%' . $lower . '%']);
            })
            ->limit(8)
            ->get(['judul', 'pengarang', 'penerbit', 'kategori',
                   'tahun_terbit', 'tempat_terbit', 'isbn', 'deskripsi']);

        return response()->json($hasil);
    }

    public function export(Request $request)
    {
        $lokasiFilter = $request->query('lokasi');
        (new TransaksiExport($lokasiFilter))->download('transaksi');
    }
}