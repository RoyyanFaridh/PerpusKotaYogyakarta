<?php

namespace Database\Seeders;

use App\Models\Paket;
use Illuminate\Database\Seeder;

class PaketSeeder extends Seeder
{
    public function run(): void
    {
        $pakets = [
            [
                'nama' => 'Paket Aktif Kotabaru',
                'is_aktif' => true,
                'lokasi_id' => 1,
            ],
            [
                'nama' => 'Paket Aktif PEVITA',
                'is_aktif' => true,
                'lokasi_id' => 2,
            ],
            [
                'nama' => 'Paket Bank Buku',
                'is_aktif' => true,
                'lokasi_id' => 3,
            ],
        ];

        foreach ($pakets as $paket) {
            Paket::create($paket);
        }
    }
}