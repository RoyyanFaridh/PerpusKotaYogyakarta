<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama'     => 'Admin Perpustakaan',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'nama'     => 'Petugas Satu',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'nama'     => 'Petugas Dua',
            'password' => Hash::make('password'),
        ]);
    }
}