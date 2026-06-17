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
use Maatwebsite\Excel\Facades\Excel;

class TransaksiController extends Controller
{
    protected TransaksiService $service;

    public function __construct(TransaksiService $service)
    {
        $this->service = $service;
    }

    /**
     * Resolve lokasi_id dari user yang sedang login.
     *
     * - Admin      : lokasi yang punya user_id = Auth::id()
     * - Superadmin : tidak punya lokasi tetap → return null
     *
     * Superadmin perlu kirim lokasi_id secara eksplisit via request
     * untuk endpoint yang butuh konteks lokasi.
     */
    private function getLokasiId(?int $fallbackFromRequest = null): ?int
    {
        if (Auth::user()->role === 'superadmin') {
            return $fallbackFromRequest;
        }

        return Auth::user()->penugasanAktif?->lokasi_id;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'tanggal', 'lokasi']);

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
                    ->orWhereHas('bukuKeluar.buku',   fn($b) => $b->where('judul', 'ilike', "%{$search}%"));
                });
            })
            ->when($filters['lokasi'] ?? null, fn($q, $lokasi) => $q->where('lokasi_snapshot', $lokasi))
            ->when($filters['tanggal'] ?? null, function ($q, $tanggal) {
                match ($tanggal) {
                    'hari_ini'   => $q->whereDate('tanggal_tukar', today()),
                    'minggu_ini' => $q->whereBetween('tanggal_tukar', [now()->startOfWeek(), now()->endOfWeek()]),
                    'bulan_ini'  => $q->whereMonth('tanggal_tukar', now()->month)
                                    ->whereYear('tanggal_tukar', now()->year),
                    default      => null,
                };
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $transaksiHariIni   = Transaksi::whereDate('created_at', today())->count();
        $transaksiMingguIni = Transaksi::whereBetween('created_at', [now()->startOfWeek(), now()])->count();
        $transaksiBulanIni  = Transaksi::whereMonth('created_at', now()->month)->count();

        $paketAktif = Paket::aktif()->with('lokasi')->get();

        $lokasiId  = $this->getLokasiId();
        $paketUser = $lokasiId
            ? Paket::aktif()->where('lokasi_id', $lokasiId)->first()
            : null;

        $lokasiList = Transaksi::where('lokasi_snapshot', '!=', null)
            ->distinct()
            ->orderBy('lokasi_snapshot')
            ->pluck('lokasi_snapshot')
            ->filter()
            ->values();

        return view('admin.transaksi.index', compact(
            'transaksi',
            'transaksiHariIni',
            'transaksiMingguIni',
            'transaksiBulanIni',
            'paketAktif',
            'paketUser',
            'lokasiList',
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member.nama'               => 'required|string|max:255',
            'member.no_telp'            => 'required|string|max:15',
            'buku_masuk.judul'     => 'required|string|max:255',
            'buku_masuk.pengarang' => 'required|string|max:255',
            'buku_keluar_id'          => 'required|exists:buku_eksemplars,id',
            'paket_masuk_id'       => 'required|exists:pakets,id',
            'paket_keluar_id'         => 'required|exists:pakets,id',
        ]);

        try {
            $this->service->simpan(array_merge(
                $request->all(),
                ['user_id' => Auth::id()]
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
            'member.nama'      => 'required|string|max:255',
            'member.no_telp'   => 'required|string|max:15',
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
            'lokasi' => $transaksi->lokasi_snapshot, // ← ganti dari paket->lokasi ke snapshot
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
            ->get(['judul', 'pengarang', 'penerbit', 'kategori', 'tahun_terbit', 'tempat_terbit', 'isbn', 'deskripsi']);

        return response()->json($hasil);
    }

    public function export(Request $request)
    {
        $lokasiFilter = $request->query('lokasi');
        (new TransaksiExport($lokasiFilter))->download('transaksi');
    }
}