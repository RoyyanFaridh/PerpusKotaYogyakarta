<?php

namespace Database\Seeders;

use Database\Seeders\UserSeeder;
use Database\Seeders\LokasiSeeder;
use Database\Seeders\MemberSeeder;
use Database\Seeders\BukuSeeder;
use Database\Seeders\PaketSeeder;
use Database\Seeders\BukuEksemplarSeeder;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            LokasiSeeder::class,        // 1. lokasi
            UserSeeder::class,          // 2. user/admin
            MemberSeeder::class,        // 3. member
            PaketSeeder::class,         // 4. paket (butuh lokasi)
            BukuSeeder::class,          // 5. master buku (butuh user)
            BukuEksemplarSeeder::class, // 6. stok buku (butuh buku & paket)
        ]);
    }
}