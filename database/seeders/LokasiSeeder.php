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
                'nama_lokasi' => 'Perpustakaan Kota Yogyakarta Pusat',
                'alamat'      => 'Jl. Suroto No.9, Kotabaru, Gondokusuman, Kota Yogyakarta',
                'no_telp'     => '(0274) 562150',
            ],
            [
                'nama_lokasi' => 'Perpustakaan Cabang Utara',
                'alamat'      => 'Jl. Kaliurang KM 5, Sleman, Yogyakarta',
                'no_telp'     => '(0274) 123456',
            ],
            [
                'nama_lokasi' => 'Perpustakaan Cabang Selatan',
                'alamat'      => 'Jl. Parangtritis KM 3, Bantul, Yogyakarta',
                'no_telp'     => '(0274) 654321',
            ],
            [
                'nama_lokasi' => 'Perpustakaan Cabang Timur',
                'alamat'      => 'Jl. Solo KM 8, Kalasan, Sleman, Yogyakarta',
                'no_telp'     => '(0274) 789012',
            ],
        ];

        foreach ($lokasis as $lokasi) {
            Lokasi::create($lokasi);
        }
    }
}