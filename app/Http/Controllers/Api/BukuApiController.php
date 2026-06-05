<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Support\Facades\Storage;

class BukuApiController extends Controller
{
    public function show(Buku $buku)
    {
        // Eager load eksemplar → paket → lokasi
        $buku->loadMissing('eksemplars.paket.lokasi');

        $eksemplars = $buku->eksemplars->map(function ($eks) {
            return [
                'stok'   => $eks->stok,
                'paket'  => $eks->paket?->nama_paket,
                'lokasi' => $eks->paket?->lokasi?->nama_lokasi,
            ];
        });

        return response()->json([
            'id'           => $buku->id,
            'judul'        => $buku->judul,
            'pengarang'    => $buku->pengarang,
            'penerbit'     => $buku->penerbit,
            'isbn'         => $buku->isbn,
            'tahun_terbit' => $buku->tahun_terbit,
            'tempat_terbit'=> $buku->tempat_terbit,
            'kategori'     => $buku->kategori,
            'deskripsi'    => $buku->deskripsi,
            'resume'       => $buku->resume,
            'cover_url'    => $buku->cover ? Storage::url($buku->cover) : null,
            'eksemplars'   => $eksemplars,
        ]);
    }
}