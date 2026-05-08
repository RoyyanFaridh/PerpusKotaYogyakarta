<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index()
    {
        $buku = Buku::all();
        return view('katalog.index', compact('buku'));
    }

    public function search(Request $request)
    {
        $query = Buku::query();

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($builder) use ($q) {
                $builder->where('judul',     'like', "%{$q}%")
                        ->orWhere('pengarang', 'like', "%{$q}%")
                        ->orWhere('resume',    'like', "%{$q}%");
            });
        }

        if ($request->filled('genre')) {
            $query->where('kategori', $request->genre);
        }

        $buku = $query->get();
        return view('katalog.index', compact('buku'));
    }

    public function searchAjax(Request $request)
    {
        $query = Buku::with('lokasi');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($builder) use ($q) {
                $builder->where('judul',     'like', "%{$q}%")
                        ->orWhere('pengarang', 'like', "%{$q}%")
                        ->orWhere('resume',    'like', "%{$q}%");
            });
        }

        if ($request->filled('genre') && $request->genre !== 'Semua') {
            $query->where('kategori', $request->genre);
        }

        $buku = $query->get();

        return response()->json([
            'total' => $buku->count(),
            'data'  => $buku->map(fn ($b) => [
                'id'           => $b->id,
                'judul'        => $b->judul,
                'pengarang'    => $b->pengarang,
                'kategori'     => $b->kategori,
                'tahun_terbit' => $b->tahun_terbit,
                'resume'       => $b->resume,
                'stok'         => $b->stok,
                'lokasi'       => $b->lokasi?->nama_lokasi ?? null,
            ]),
        ]);
    }

    public function show($book)
    {
        $buku = Buku::findOrFail($book);
        return view('katalog.show', compact('buku'));
    }
}