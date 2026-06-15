<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CatalogController extends Controller
{
    public function index()
    {
        $buku    = Buku::with('lokasi')->visible()->tersedia()->latest()->get();
        $lokasis = Lokasi::aktif()->tampilDiSearch()->get(['id', 'nama_lokasi']);

        return view('katalog.index', compact('buku', 'lokasis'));
    }

    public function search(Request $request)
    {
        $query = Buku::with('lokasi')->visible()->tersedia();

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
        $query = Buku::with(['eksemplars.paket.lokasi'])
            ->visible()
            ->tersedia();

        if ($request->filled('q')) {
            $query->cari($request->q);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('lokasi_id')) {
            $query->whereHas('eksemplars.paket.lokasi', fn($l) =>
                $l->where('id', $request->lokasi_id)
            );
        }

        $buku = $query->get();

        return response()->json([
            'total' => $buku->count(),
            'data'  => $buku->map(function ($b) {
                $eksemplarsAktif = $b->eksemplars
                    ->filter(fn($e) => $e->paket?->is_aktif && $e->stok > 0);

                $lokasis = $eksemplarsAktif
                    ->map(fn($e) => $e->paket?->lokasi?->nama_lokasi)
                    ->filter()
                    ->unique()
                    ->values();

                return [
                    'id'           => $b->id,
                    'judul'        => $b->judul,
                    'pengarang'    => $b->pengarang,
                    'kategori'     => $b->kategori,
                    'tahun_terbit' => $b->tahun_terbit,
                    'resume'       => $b->resume,
                    'stok'         => $eksemplarsAktif->sum('stok'),
                    'lokasis'      => $lokasis,
                    'cover_url'    => $b->cover ? Storage::url($b->cover) : null,
                ];
            }),
        ]);
    }
    
    public function show(int $book)
    {
        $buku = Buku::with('lokasi')->visible()->findOrFail($book);
        return view('katalog.show', compact('buku'));
    }
}