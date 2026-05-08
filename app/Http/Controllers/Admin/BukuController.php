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
        $filters  = $request->only(['search', 'kategori', 'kondisi', 'stok']);
        $bukus    = $this->service->getAll($filters);
        $lokasis  = Lokasi::all();
        $stats    = $this->getStats();

        return view('admin.buku.index', compact('bukus', 'lokasis', 'filters', 'stats'));
    }

    public function store(SimpanBukuRequest $request)
    {
        $this->service->store(array_merge(
            $request->validated(),
            ['user_id' => Auth::id()] 
        ));

        return redirect()->back()->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $buku = Buku::findOrFail($id);

        if (request()->ajax()) {
            return response()->json($buku);
        }

        return view('admin.buku.edit', compact('buku'));
    }

    public function create()
    {
        $lokasis = Lokasi::all();
        return view('admin.buku.create', compact('lokasis'));
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

    private function getStats(): array
    {
        return [
            'total'    => Buku::count(),
            'perpus'   => Buku::perpus()->count(),
            'tukar'    => Buku::tukar()->count(),
            'tersedia' => Buku::where('stok', '>', 0)->count(),
            'habis'    => Buku::where('stok', 0)->count(),
        ];
    }
}