<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SimpanBukuRequest;
use App\Models\Buku;
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
        $filters    = $request->only(['search', 'kategori', 'paket', 'visibility']);
        $pakets     = $this->service->getAllGroupedByPaket();
        $tanpaPaket = $this->service->getTanpaPaket();
        $stats      = $this->service->getStats();

        return view('admin.buku.index', compact('pakets', 'tanpaPaket', 'filters', 'stats'));
    }

    public function export(Request $request): never
    {
        $this->service->export(
            $request->only(['search', 'kategori', 'paket', 'visibility']),
            $request->boolean('publik')
        );
    }

    public function show(int $id)
    {
        $buku = Buku::with(['eksemplars.paket.lokasi'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'buku'    => [
                'id'            => $buku->id,
                'judul'         => $buku->judul,
                'pengarang'     => $buku->pengarang,
                'penerbit'      => $buku->penerbit,
                'isbn'          => $buku->isbn,
                'tahun_terbit'  => $buku->tahun_terbit,
                'tempat_terbit' => $buku->tempat_terbit,
                'resume'        => $buku->resume,
                'cover'         => $buku->cover,
                'kategori'      => $buku->kategori,
                'deskripsi'     => $buku->deskripsi,
                'is_visible'    => $buku->is_visible,
                'total_stok'    => $buku->total_stok,
                'eksemplars'    => $buku->eksemplars,
            ],
        ]);
    }

    public function store(SimpanBukuRequest $request)
    {
        $validated            = $request->validated();
        $validated['user_id'] = Auth::id();

        $this->service->store($validated);

        return redirect()->route('admin.buku.index')
                         ->with('success', 'Buku berhasil ditambahkan.');
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
        $buku->update(['is_visible' => ! $buku->is_visible]);

        return response()->json([
            'success'    => true,
            'is_visible' => $buku->is_visible,
            'message'    => $buku->is_visible ? 'Buku ditampilkan.' : 'Buku disembunyikan.',
        ]);
    }
}