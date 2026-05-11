<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kegiatan;

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
        ]);
    }
}