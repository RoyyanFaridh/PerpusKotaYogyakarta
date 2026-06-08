<?php

namespace Database\Seeders;

use App\Models\Lokasi;
use App\Models\User;
use Illuminate\Database\Seeder;

class LokasiSeeder extends Seeder
{
    public function run(): void
    {
        $petugas1 = User::where('email', 'petugas1@perpus.com')->first();
        $petugas2 = User::where('email', 'petugas2@perpus.com')->first();

        Lokasi::create([
            'nama_lokasi'      => 'Perpustakaan Kotabaru',
            'alamat'           => 'Jl. Suroto No.9, Kotabaru, Kec. Gondokusuman, Kota Yogyakarta, DIY 55224',
            'no_telp'          => '(0274) 511314',
            'user_id'          => $petugas1?->id,
            'tampil_di_search' => true,
            'aktif'            => true,
        ]);

        Lokasi::create([
            'nama_lokasi'      => 'PEVITA',
            'alamat'           => 'Jl. Mayjend Sutoyo No.32, Mantrijeron, Kota Yogyakarta, DIY 55143',
            'no_telp'          => '081226839100',
            'user_id'          => $petugas2?->id,
            'tampil_di_search' => true,
            'aktif'            => true,
        ]);

        Lokasi::create([
            'nama_lokasi'      => 'Bank Buku',
            'alamat'           => '',
            'no_telp'          => '',
            'user_id'          => null,
            'tampil_di_search' => false,
            'aktif'            => true,
        ]);
    }
}