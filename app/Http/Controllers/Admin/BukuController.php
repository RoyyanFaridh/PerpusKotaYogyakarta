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

    public function perpus(Request $request)
    {
        $filters  = $request->only(['search', 'kategori', 'stok']);
        $bukus    = $this->service->getPerpus($filters);
        $lokasis  = Lokasi::all();
        $stats    = $this->getStatsPerpus();

        return view('admin.buku.perpus', compact('bukus', 'lokasis', 'filters', 'stats'));
    }

    public function tukar(Request $request)
    {
        $filters  = $request->only(['search', 'kategori', 'kondisi']);
        $bukus    = $this->service->getTukar($filters);
        $stats    = $this->getStatsTukar();

        return view('admin.buku.tukar', compact('bukus', 'filters', 'stats'));
    }

    public function store(SimpanBukuRequest $request)
    {
        $this->service->store(array_merge(
            $request->validated(),
            ['user_id' => Auth::id()] 
        ));

        return redirect()->back()->with('success', 'Buku berhasil ditambahkan.');
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

    private function getStatsPerpus(): array
    {
        return [
            'total'    => Buku::perpus()->count(),
            'tersedia' => Buku::perpus()->where('stok', '>', 0)->count(),
            'habis'    => Buku::perpus()->where('stok', 0)->count(),
            'kategori' => Buku::perpus()->whereNotNull('kategori')->distinct('kategori')->count('kategori'),
        ];
    }

    private function getStatsTukar(): array
    {
        return [
            'total' => Buku::tukar()->count(),
            'baik'  => Buku::tukar()->where('kondisi', 'baik')->count(),
            'cukup' => Buku::tukar()->where('kondisi', 'cukup')->count(),
            'rusak' => Buku::tukar()->where('kondisi', 'rusak')->count(),
        ];
    }
}