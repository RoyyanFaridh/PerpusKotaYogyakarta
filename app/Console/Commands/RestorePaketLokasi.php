<?php

namespace App\Console\Commands;

use App\Models\Kegiatan;
use Illuminate\Console\Command;

class RestorePaketLokasi extends Command
{
    protected $signature   = 'kegiatan:restore-paket';
    protected $description = 'Restore lokasi paket setelah kegiatan selesai';

    public function handle(): void
    {
        // 1. Pindah lokasi paket untuk kegiatan yang baru mulai
        Kegiatan::with('pakets')
            ->where('lokasi_dipindah', false)  // flag baru
            ->where('status_restore', false)
            ->get()
            ->filter(fn($k) => $k->status_otomatis === 'sedang_berlangsung')
            ->each(function ($kegiatan) {
                if (!$kegiatan->lokasi_id) return;

                foreach ($kegiatan->pakets as $paket) {
                    $paket->update(['lokasi_id' => $kegiatan->lokasi_id]);
                }
                $kegiatan->update(['lokasi_dipindah' => true]);
            });

        // 2. Restore lokasi paket untuk kegiatan yang selesai
        Kegiatan::with('pakets')
            ->where('lokasi_dipindah', true)
            ->where('status_restore', false)
            ->get()
            ->filter(fn($k) => $k->status_otomatis === 'selesai')
            ->each(function ($kegiatan) {
                foreach ($kegiatan->pakets as $paket) {
                    if ($paket->pivot->lokasi_asal_id) {
                        $paket->update(['lokasi_id' => $paket->pivot->lokasi_asal_id]);
                    }
                }
                $kegiatan->update(['status_restore' => true]);
            });
    }
}