<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Services\TransaksiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    protected TransaksiService $service;

    public function __construct(TransaksiService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $transaksi = Transaksi::with(['member', 'bukuDiserahkan', 'bukuDiterima'])
            ->latest()
            ->paginate(15);

        $transaksiHariIni   = Transaksi::whereDate('created_at', today())->count();
        $transaksiMingguIni = Transaksi::whereBetween('created_at', [now()->startOfWeek(), now()])->count();
        $transaksiBulanIni  = Transaksi::whereMonth('created_at', now()->month)->count();

        return view('admin.transaksi.index', compact(
            'transaksi',
            'transaksiHariIni',
            'transaksiMingguIni',
            'transaksiBulanIni',
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member.nama'                  => 'required|string|max:255',
            'member.no_telp'               => 'required|string|max:15',
            'buku_diserahkan.judul'        => 'required|string|max:255',
            'buku_diserahkan.pengarang'    => 'required|string|max:255',
            'buku_diserahkan.kondisi'      => 'required|in:baik,cukup,rusak',
            'buku_diterima_id'             => 'required|exists:bukus,id',
        ]);

        try {
            $this->service->simpan(array_merge(
                $request->all(),
                ['user_id' => Auth::id()]
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

        $this->service->update($id, $request->all());

        return response()->json(['success' => true, 'message' => 'Transaksi berhasil diperbarui.']);
    }

    public function destroy(int $id)
    {
        $this->service->delete($id);

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus.');
    }

    public function show(int $id)
    {
        $transaksi = Transaksi::with(['member', 'bukuDiserahkan', 'bukuDiterima', 'user'])
            ->findOrFail($id);

        return response()->json($transaksi);
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
        $buku = $this->service->cariBukuByIsbn($request->isbn ?? '');
        return response()->json($buku);
    }
}