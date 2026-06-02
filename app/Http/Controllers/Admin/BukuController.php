<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SimpanBukuRequest;
use App\Models\Buku;
use App\Models\Lokasi;
use App\Models\Paket;
use App\Services\BukuService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BukuController extends Controller
{
    protected BukuService $service;

    public function __construct(BukuService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'kategori', 'lokasi', 'paket', 'visibility']);
        $bukus   = $this->service->getAll($filters);
        $lokasis = Lokasi::aktif()->get();
        $pakets  = Paket::orderBy('nama')->get();
        $stats   = $this->getStats();

        return view('admin.buku.index', compact('bukus', 'lokasis', 'pakets', 'filters', 'stats'));
    }

    public function create()
    {
        $lokasis = Lokasi::aktif()->get();
        $pakets  = Paket::orderBy('nama')->get();
        return view('admin.buku.create', compact('lokasis', 'pakets'));
    }

    public function store(SimpanBukuRequest $request)
    {
        $validated            = $request->validated();
        $validated['user_id'] = Auth::id();

        $this->service->store($validated);

        return redirect()->route('admin.buku.index')
                         ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $buku    = Buku::findOrFail($id);
        $lokasis = Lokasi::aktif()->get();
        $pakets  = Paket::orderBy('nama')->get();
        return view('admin.buku.edit', compact('buku', 'lokasis', 'pakets'));
    }

    public function show(int $id)
    {
        return response()->json(
            Buku::with(['lokasi', 'paket'])->findOrFail($id)
        );
    }

    public function update(SimpanBukuRequest $request, int $id)
    {
        $this->service->update($id, $request->validated());

        return redirect()->back()
                         ->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $this->service->delete($id);

        return redirect()->back()
                         ->with('success', 'Buku berhasil dihapus.');
    }

    public function toggleVisibility(int $id)
    {
        $buku = Buku::findOrFail($id);

        if ($buku->paket_id !== null) {
            return response()->json([
                'success' => false,
                'message' => 'Visibility buku dalam paket dikontrol oleh status paket.',
            ], 422);
        }

        $buku->update(['is_visible' => ! $buku->is_visible]);

        return response()->json([
            'success'    => true,
            'is_visible' => $buku->is_visible,
            'message'    => $buku->is_visible ? 'Buku ditampilkan.' : 'Buku disembunyikan.',
        ]);
    }

    private function getStats(): array
    {
        $stats = Buku::selectRaw("
            COUNT(*) as total,
            SUM(CASE WHEN paket_id IS NULL     THEN 1 ELSE 0 END) as donasi,
            SUM(CASE WHEN paket_id IS NOT NULL THEN 1 ELSE 0 END) as dalam_paket,
            SUM(CASE WHEN stok > 0             THEN 1 ELSE 0 END) as tersedia,
            SUM(CASE WHEN stok = 0             THEN 1 ELSE 0 END) as habis
        ")->first();
        return (array) $stats;
    }
}