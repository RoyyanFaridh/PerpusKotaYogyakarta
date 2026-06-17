<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Lokasi;
use App\Models\UserLokasi;
use Illuminate\Database\Seeder;

class UserLokasiSeeder extends Seeder
{
    public function run(): void
    {
        $lokasis = Lokasi::orderBy('id')->get();

        if ($lokasis->isEmpty()) {
            $this->command->warn('UserLokasiSeeder: tidak ada lokasi, skip seeding penugasan.');
            return;
        }

        $superadmin = User::where('role', 'superadmin')->first();
        $petugas1   = User::where('email', 'petugas1@perpus.com')->first();
        $petugas2   = User::where('email', 'petugas2@perpus.com')->first();

        if (! $superadmin) {
            $this->command->warn('UserLokasiSeeder: superadmin tidak ditemukan, assigned_by tidak bisa diisi.');
            return;
        }
        
        if ($petugas1 && ! $petugas1->penugasanAktif()->exists()) {
            UserLokasi::create([
                'user_id'     => $petugas1->id,
                'lokasi_id'   => $lokasis->first()->id,
                'assigned_by' => $superadmin->id,
                'assigned_at' => now(),
            ]);
        }

        if ($petugas2 && ! $petugas2->penugasanAktif()->exists()) {
            $targetLokasis = $lokasis->count() >= 2 ? $lokasis->take(2) : $lokasis->take(1);

            foreach ($targetLokasis as $lokasi) {
                UserLokasi::create([
                    'user_id'     => $petugas2->id,
                    'lokasi_id'   => $lokasi->id,
                    'assigned_by' => $superadmin->id,
                    'assigned_at' => now(),
                ]);
            }
        }
    }
}