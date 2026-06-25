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
                'username' => 'admin',          
                'email'    => 'admin@perpus.com',
                'password' => Hash::make('password'),
                'role'     => 'superadmin',
            ],
            [
                'nama'     => 'Petugas Satu',
                'username' => 'petugas1',      
                'email'    => 'petugas1@perpus.com',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ],
            [
                'nama'     => 'Petugas Dua',
                'username' => 'petugas2',  
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