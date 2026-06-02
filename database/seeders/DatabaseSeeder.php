<?php

namespace Database\Seeders;

use Database\Seeders\UserSeeder;
use Database\Seeders\LokasiSeeder;
use Database\Seeders\MemberSeeder;
use Database\Seeders\BukuSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            LokasiSeeder::class,
            UserSeeder::class,
            MemberSeeder::class,
            BukuSeeder::class,
        ]);
    }
}