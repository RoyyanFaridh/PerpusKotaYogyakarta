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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'         => ['required', 'string', 'max:255'],
            'pengarang'     => ['required', 'string', 'max:255'],
            'penerbit'      => ['nullable', 'string', 'max:255'],
            'isbn'          => ['nullable', 'string', 'max:20'],
            'tahun_terbit'  => ['nullable', 'integer'],
            'tempat_terbit' => ['nullable', 'string', 'max:255'],
            'resume'        => ['nullable', 'string'],
            'stok'          => ['required', 'integer', 'min:0'],
            'kategori'      => ['nullable', 'string', 'max:100'],
            'sumber'        => ['required', 'in:perpus,tukar'],
            'kondisi'       => ['nullable', 'string', 'max:100'],
            'deskripsi'     => ['nullable', 'string'],
            'lokasi_id'     => ['required', 'exists:lokasis,id'],
        ]);

        $validated['user_id'] = Auth::id();

        $this->service->store($validated); 

        return redirect()->route('admin.buku.index')
                        ->with('success', 'Buku berhasil ditambahkan.');
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