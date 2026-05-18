<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Lokasi;
use App\Models\Buku;
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

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'tanggal']);

        $transaksi = Transaksi::with(['member', 'bukuDiserahkan', 'bukuDiterima'])
            ->when($filters['search'] ?? null, function ($q, $search) {
                $q->where(function ($q) use ($search) {
                    $q->whereHas('member', fn($m) =>
                            $m->where('nama', 'like', "%{$search}%")
                            ->orWhere('no_telp', 'like', "%{$search}%"))
                    ->orWhereHas('bukuDiserahkan', fn($b) => $b->where('judul', 'like', "%{$search}%"))
                    ->orWhereHas('bukuDiterima',   fn($b) => $b->where('judul', 'like', "%{$search}%"));
                });
            })
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

        $lokasis    = Lokasi::all();
        $lokasiUser = Auth::user()->lokasi;

        return view('admin.transaksi.index', compact(
            'transaksi',
            'transaksiHariIni',
            'transaksiMingguIni',
            'transaksiBulanIni',
            'lokasis',
            'lokasiUser',
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member.nama'               => 'required|string|max:255',
            'member.no_telp'            => 'required|string|max:15',
            'buku_diserahkan.judul'     => 'required|string|max:255',
            'buku_diserahkan.pengarang' => 'required|string|max:255',
            'buku_diserahkan.kondisi'   => 'required|in:baik,cukup,rusak',
            'buku_diterima_id'          => 'required|exists:bukus,id',
            // lokasi_id tidak dari request — diambil dari user yang login
        ]);

        try {
            $this->service->simpan(array_merge(
                $request->all(),
                [
                    'user_id'   => Auth::id(),
                    'lokasi_id' => Auth::user()->lokasi_id, // otomatis dari cabang petugas
                ]
            ));

            return response()->json(['success' => true, 'message' => 'Transaksi berhasil disimpan.']);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ], 500);
        }
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'member.nama'      => 'required|string|max:255',
            'member.no_telp'   => 'required|string|max:15',
            'buku_diterima_id' => 'required|exists:bukus,id',
        ]);

        try {
            $this->service->update($id, $request->all());

            return response()->json(['success' => true, 'message' => 'Transaksi berhasil diperbarui.']);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
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
        $transaksi = Transaksi::with(['member', 'bukuDiserahkan.lokasi', 'bukuDiterima', 'user'])
            ->findOrFail($id);

        return response()->json([
            ...$transaksi->toArray(),
            'lokasi_id' => $transaksi->bukuDiserahkan?->lokasi_id,
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
        $buku = $this->service->cariBukuByIsbn(
            $request->isbn    ?? '',
            $request->integer('lokasi_id') ?: null,
        );
        return response()->json($buku);
    }

    public function cariBukuJudul(Request $request)
    {
        $hasil = $this->service->cariBukuByJudul(
            $request->keyword ?? '',
            $request->integer('lokasi_id') ?: null,
        );
        return response()->json($hasil);
    }

    public function bukuByLokasi()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $buku = Buku::where('lokasi_id', $user->lokasi_id)
                    ->where('stok', '>', 0)
                    ->where('sumber', 'perpus')
                    ->orderBy('judul')
                    ->get(['id', 'judul', 'pengarang', 'stok', 'lokasi_id']);

        return response()->json($buku);
    }

    public function export()
    {
        $filename = 'transaksi-' . now()->format('Y-m-d') . '.xlsx';
        return Excel::download(new TransaksiExport, $filename);
    }
}