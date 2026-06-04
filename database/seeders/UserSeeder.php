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
            'email'    => 'admin@perpus.com',
            'no_hp'    => '081234567890',
            'password' => Hash::make('password'),
            'role'     => 'superadmin',
        ]);

        User::create([
            'nama'     => 'Petugas Satu',
            'email'    => 'petugas1@perpus.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        User::create([
            'nama'     => 'Petugas Dua',
            'email'    => 'petugas2@perpus.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);
    }
}