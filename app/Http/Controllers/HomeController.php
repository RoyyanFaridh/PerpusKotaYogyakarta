<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kegiatan;
use App\Models\Member;
use App\Models\Transaksi;
use App\Models\Lokasi;
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
            'totalBuku'    => Buku::count(),
            'totalAnggota' => Member::count(),
            'totalTukar'   => Transaksi::count(),
            'kegiatan'     => $kegiatan,
            'closestIndex' => $closestIndex,
            'lokasis'      => Lokasi::orderBy('nama_lokasi')->get(),
            'bukuTerbaru'  => Buku::with('lokasi')->orderBy('created_at', 'desc')->take(5)->get(),
        ]);
    }

    public function searchBuku(Request $request)
    {
        $query = Buku::query()->with('lokasi');

        if ($request->q)
            $query->where(fn($q) => $q->where('judul', 'like', "%{$request->q}%")
                                    ->orWhere('pengarang', 'like', "%{$request->q}%"));

        if ($request->kategori)
            $query->where('kategori', $request->kategori);

        if ($request->lokasi_id)
            $query->where('lokasi_id', $request->lokasi_id);

        $paginated = $query->paginate(12);

        $paginated->getCollection()->transform(fn($buku) => [
            'id'           => $buku->id,
            'judul'        => $buku->judul,
            'pengarang'    => $buku->pengarang,
            'kategori'     => $buku->kategori,
            'tahun_terbit' => $buku->tahun_terbit,
            'resume'       => $buku->resume,
            'stok'         => $buku->stok,
            'lokasi_id'    => $buku->lokasi_id,
            'lokasi'       => $buku->lokasi?->nama_lokasi,
            'cover_url'    => $buku->cover ? Storage::url($buku->cover) : null,
        ]);

        return response()->json($paginated);
    }
}