<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'nama'     => 'Admin Perpustakaan',
                'email'    => 'admin@perpus.com',
                'no_hp'    => '081234567890',
                'password' => Hash::make('password'),
                'role'     => 'superadmin',
            ],
            [
                'nama'     => 'Petugas Satu',
                'email'    => 'petugas1@perpus.com',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ],
            [
                'nama'     => 'Petugas Dua',
                'email'    => 'petugas2@perpus.com',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ],
        ];

        foreach ($users as $data) {
            User::firstOrCreate(['email' => $data['email']], $data);
        }
    }
}