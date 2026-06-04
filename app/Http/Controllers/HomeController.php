<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kegiatan;
use App\Models\Lokasi;
use App\Models\Member;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        $kegiatan = Kegiatan::orderBy('tanggal_mulai')->get();

        $sorted = $kegiatan->sortBy(function ($item) {
            $s   = $item->status_otomatis;
            $tgl = \Carbon\Carbon::parse($item->tanggal_mulai)->timestamp;
            return [$s === 'selesai' ? 0 : 1, $tgl];
        })->values();

        $closestIndex = 0;
        foreach ($sorted as $i => $item) {
            $s = $item->status_otomatis;
            if ($s === 'sedang_berlangsung' || $s === 'akan_berlangsung') {
                $closestIndex = $i;
                break;
            }
        }

        return view('welcome', [
            'totalBuku'    => Buku::visible()->tersedia()->count(),
            'totalAnggota' => Member::count(),
            'totalTukar'   => Transaksi::count(),
            'kegiatan'     => $sorted,
            'closestIndex' => $closestIndex,
            'lokasis'      => Lokasi::aktif()->tampilDiSearch()->orderBy('nama_lokasi')->get(),
            'bukuTerbaru'  => Buku::with(['eksemplars.paket.lokasi'])
                                  ->visible()
                                  ->tersedia()
                                  ->latest()
                                  ->take(10)
                                  ->get(),
        ]);
    }

    public function searchBuku(Request $request)
    {
        $query = Buku::with(['eksemplars.paket.lokasi'])
            ->visible()
            ->tersedia();

        if ($request->q)
            $query->cari($request->q);

        if ($request->kategori)
            $query->where('kategori', $request->kategori);

        if ($request->lokasi_id) {
            $query->whereHas('eksemplars.paket.lokasi', fn($l) =>
                $l->where('id', $request->lokasi_id)
            );
        }

        $paginated = $query->paginate(12);

        $paginated->getCollection()->transform(function ($buku) {
            $lokasis = $buku->eksemplars
                ->filter(fn($e) => $e->paket?->is_aktif && $e->stok > 0)
                ->map(fn($e) => $e->paket?->lokasi?->nama_lokasi)
                ->filter()
                ->unique()
                ->values();

            return [
                'id'           => $buku->id,
                'judul'        => $buku->judul,
                'pengarang'    => $buku->pengarang,
                'kategori'     => $buku->kategori,
                'tahun_terbit' => $buku->tahun_terbit,
                'resume'       => $buku->resume,
                'stok'         => $buku->stok,
                'lokasis'      => $lokasis,
                'cover_url'    => $buku->cover ? Storage::url($buku->cover) : null,
            ];
        });

        return response()->json($paginated);
    }
}