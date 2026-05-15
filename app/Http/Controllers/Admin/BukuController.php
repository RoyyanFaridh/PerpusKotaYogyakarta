<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SimpanBukuRequest;
use App\Models\Buku;
use App\Models\Lokasi;
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
        $filters = $request->only(['search', 'kategori', 'kondisi', 'stok']);
        $bukus   = $this->service->getAll($filters);
        $lokasis = Lokasi::all();
        $stats   = $this->getStats();

        // Bug 4 fix: hapus Member::all() yang tidak dipakai di view buku
        return view('admin.buku.index', compact('bukus', 'lokasis', 'filters', 'stats'));
    }

    public function create()
    {
        $lokasis = Lokasi::all();
        return view('admin.buku.create', compact('lokasis'));
    }

    // Bug 1 fix: store sekarang pakai SimpanBukuRequest seperti update
    public function store(SimpanBukuRequest $request)
    {
        $validated            = $request->validated();
        $validated['user_id'] = Auth::id();

        $this->service->store($validated);

        return redirect()->route('admin.buku.index')
                         ->with('success', 'Buku berhasil ditambahkan.');
    }

    // Bug 3 fix: edit hanya return view, tidak campur dengan response JSON
    public function edit(int $id)
    {
        $buku    = Buku::findOrFail($id);
        $lokasis = Lokasi::all();
        return view('admin.buku.edit', compact('buku', 'lokasis'));
    }

    // Bug 3 fix: show khusus untuk AJAX — terpisah dari edit
    public function show(int $id)
    {
        return response()->json(Buku::with('lokasi')->findOrFail($id));
    }

    public function update(SimpanBukuRequest $request, int $id)
    {
        $this->service->update($id, $request->validated());

        return redirect()->back()->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $this->service->delete($id);

        return redirect()->back()->with('success', 'Buku berhasil dihapus.');
    }

    // Bug 5 fix: 5 query terpisah digabung jadi 1 query
    private function getStats(): array
    {
        $stats = Buku::selectRaw("
            COUNT(*) as total,
            SUM(sumber = 'perpus') as perpus,
            SUM(sumber = 'tukar') as tukar,
            SUM(stok > 0) as tersedia,
            SUM(stok = 0) as habis
        ")->first();

        return $stats->toArray();
    }
}