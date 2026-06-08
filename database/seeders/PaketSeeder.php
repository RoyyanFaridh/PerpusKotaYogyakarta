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
                'nama' => 'Paket A',
                'is_aktif' => true,
                'lokasi_id' => 1,
            ],
            [
                'nama' => 'Paket B',
                'is_aktif' => true,
                'lokasi_id' => 2,
            ],
            [
                'nama' => 'Paket C',
                'is_aktif' => true,
                'lokasi_id' => 3,
            ],
            [
                'nama' => 'Paket D',
                'is_aktif' => true,
                'lokasi_id' => 3,
            ],
        ];

        foreach ($pakets as $paket) {
            Paket::create($paket);
        }
    }
}