<?php

namespace Database\Seeders;

use Database\Seeders\UserSeeder;
use Database\Seeders\UserPermissionSeeder;
use Database\Seeders\LokasiSeeder;
use Database\Seeders\UserLokasiSeeder;
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
            UserSeeder::class,
            UserPermissionSeeder::class,
            LokasiSeeder::class,
            UserLokasiSeeder::class,   
            MemberSeeder::class,
            PaketSeeder::class,
            BukuSeeder::class,
            BukuEksemplarSeeder::class,
        ]);
    }
}