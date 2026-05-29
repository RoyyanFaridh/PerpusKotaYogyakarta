<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SimpanBukuRequest;
use App\Models\Buku;
use App\Models\Lokasi;
use App\Services\BukuService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    protected BukuService $service;

    public function __construct(BukuService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'kategori', 'kondisi', 'lokasi']);
        $bukus   = $this->service->getAll($filters);
        $lokasis = Lokasi::all();
        $stats   = $this->getStats();

        return view('admin.buku.index', compact('bukus', 'lokasis', 'filters', 'stats'));
    }

    public function create()
    {
        $lokasis = Lokasi::all();
        return view('admin.buku.create', compact('lokasis'));
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
        $lokasis = Lokasi::all();

        return view('admin.buku.edit', compact('buku', 'lokasis'));
    }

    public function show(int $id)
    {
        return response()->json(Buku::with('lokasi')->findOrFail($id));
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

    private function getStats(): array
    {
        $stats = DB::table('bukus')
            ->selectRaw("
                COUNT(*) as total,
                SUM(CASE WHEN sumber = 'perpus' THEN 1 ELSE 0 END) as perpus,
                SUM(CASE WHEN sumber = 'tukar' THEN 1 ELSE 0 END) as tukar,
                SUM(CASE WHEN stok > 0 THEN 1 ELSE 0 END) as tersedia,
                SUM(CASE WHEN stok = 0 THEN 1 ELSE 0 END) as habis
            ")
            ->first();

        return (array) $stats;
    }
}