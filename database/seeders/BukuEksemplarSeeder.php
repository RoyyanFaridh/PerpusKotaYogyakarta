<?php

namespace Database\Seeders;

use App\Models\BukuEksemplar;
use Illuminate\Database\Seeder;

class BukuEksemplarSeeder extends Seeder
{
    public function run(): void
    {
        $eksemplars = [
            [
                'buku_id' => 1,
                'paket_id' => 1,
                'stok' => 3,
            ],
            [
                'buku_id' => 2,
                'paket_id' => 1,
                'stok' => 2,
            ],
            [
                'buku_id' => 3,
                'paket_id' => 2,
                'stok' => 2,
            ],
            [
                'buku_id' => 4,
                'paket_id' => 1,
                'stok' => 5,
            ],
            [
                'buku_id' => 5,
                'paket_id' => 2,
                'stok' => 4,
            ],
            [
                'buku_id' => 6,
                'paket_id' => 1,
                'stok' => 3,
            ],
            [
                'buku_id' => 7,
                'paket_id' => 2,
                'stok' => 2,
            ],
            [
                'buku_id' => 8,
                'paket_id' => 1,
                'stok' => 4,
            ],
            [
                'buku_id' => 9,
                'paket_id' => 2,
                'stok' => 6,
            ],
            [
                'buku_id' => 10,
                'paket_id' => 1,
                'stok' => 3,
            ],
        ];

        foreach ($eksemplars as $eksemplar) {
            BukuEksemplar::create($eksemplar);
        }
    }
}