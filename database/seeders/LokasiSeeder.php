<?php

namespace Database\Seeders;

use App\Models\Lokasi;
use Illuminate\Database\Seeder;

class LokasiSeeder extends Seeder
{
    public function run(): void
    {
        $lokasis = [
            [
                'nama_lokasi'      => 'Perpustakaan Kotabaru',
                'alamat'           => 'Jl. Suroto No.9, Kotabaru, Kec. Gondokusuman, Kota Yogyakarta, DIY 55224',
                'no_telp'          => '(0274) 511314',
                'tampil_di_search' => true,
                'aktif'            => true,
            ],
            [
                'nama_lokasi'      => 'PEVITA',
                'alamat'           => 'Jl. Mayjend Sutoyo No.32, Mantrijeron, Kota Yogyakarta, DIY 55143',
                'no_telp'          => '081226839100',
                'tampil_di_search' => true,
                'aktif'            => true,
            ],
            [
                'nama_lokasi'      => 'Bank Buku',
                'alamat'           => '',
                'no_telp'          => '',
                'tampil_di_search' => false,
                'aktif'            => true,
            ],
        ];

        foreach ($lokasis as $lokasi) {
            Lokasi::create($lokasi);
        }
    }
}