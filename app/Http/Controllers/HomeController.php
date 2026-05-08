<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kegiatan;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome', [
            'totalBuku'    => Buku::count(),
            'totalAnggota' => \App\Models\Member::count(),
            'totalTukar'   => \App\Models\Transaksi::count(),
            'kegiatan'     => Kegiatan::orderBy('tanggal_mulai')->get(),
        ]);
    }
}