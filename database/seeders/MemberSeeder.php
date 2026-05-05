<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            [
                'nik'      => '3404012345670001',
                'nama'     => 'Fajar Nugroho',
                'no_telp'  => '081234567890',
                'alamat'   => 'Jl. Malioboro No.12, Gedongtengen, Yogyakarta',
                'email'    => 'fajar@email.com',
                'user_id'  => 1,
            ],
            [
                'nik'      => '3404019876540002',
                'nama'     => 'Siti Rahayu',
                'no_telp'  => '081398765432',
                'alamat'   => 'Jl. Gejayan No.5, Depok, Sleman',
                'email'    => 'siti@email.com',
                'user_id'  => 1,
            ],
            [
                'nik'      => '3404011122330003',
                'nama'     => 'Eko Prasetyo',
                'no_telp'  => '085711223344',
                'alamat'   => 'Jl. Monjali No.8, Sleman, Yogyakarta',
                'email'    => 'eko@email.com',
                'user_id'  => 2,
            ],
            [
                'nik'      => '3404015566780004',
                'nama'     => 'Dewi Lestari',
                'no_telp'  => '082155667788',
                'alamat'   => 'Jl. Bantul No.22, Bantul, Yogyakarta',
                'email'    => 'dewi@email.com',
                'user_id'  => 2,
            ],
            [
                'nik'      => '3404014433220005',
                'nama'     => 'Rina Wulandari',
                'no_telp'  => '081944332211',
                'alamat'   => 'Jl. Imogiri No.15, Bantul, Yogyakarta',
                'email'    => 'rina@email.com',
                'user_id'  => 3,
            ],
        ];

        foreach ($members as $member) {
            Member::create($member);
        }
    }
}