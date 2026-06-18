<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kegiatans', function (Blueprint $table) {
            $table->boolean('lokasi_dipindah')->default(false)->after('jam_selesai');
            $table->boolean('status_restore')->default(false)->after('lokasi_dipindah');
        });

        Schema::table('kegiatan_paket', function (Blueprint $table) {
            $table->foreignId('lokasi_asal_id')
                ->nullable()
                ->constrained('lokasis')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('kegiatan_paket', function (Blueprint $table) {
            $table->dropForeign(['lokasi_asal_id']);
            $table->dropColumn('lokasi_asal_id');
        });

        Schema::table('kegiatans', function (Blueprint $table) {
            $table->dropColumn(['lokasi_dipindah', 'status_restore']); // hapus lokasi_id dari sini
        });
    }
};
