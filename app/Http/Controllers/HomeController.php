<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kegiatan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $kegiatan = Kegiatan::orderBy('tanggal_mulai')->get();

        // Sorting: selesai di atas, aktif/akan datang di bawah, masing-masing urut tanggal ASC
        $sorted = $kegiatan->sortBy(function ($item) {
            $s   = $item->status_otomatis;
            $tgl = \Carbon\Carbon::parse($item->tanggal_mulai)->timestamp;
            return [$s === 'selesai' ? 0 : 1, $tgl];
        })->values();

        // Cari index kegiatan terdekat yang aktif/akan datang
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
            'totalAnggota' => \App\Models\Member::count(),
            'totalTukar'   => \App\Models\Transaksi::count(),
            'kegiatan'     => $kegiatan,
            'closestIndex' => $closestIndex,
            'lokasis'      => \App\Models\Lokasi::orderBy('nama_lokasi')->get(),
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
        ]);

        return response()->json($paginated);
    }
}