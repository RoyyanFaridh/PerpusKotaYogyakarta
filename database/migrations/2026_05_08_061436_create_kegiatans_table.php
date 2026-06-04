<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kegiatans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kegiatan');
            $table->text('deskripsi')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->time('jam_pelaksanaan')->nullable();
            $table->time('jam_selesai')->nullable();
            $table->timestamps();
        });

        Schema::create('kegiatan_paket', function (Blueprint $table) {
            $table->foreignId('kegiatan_id')->constrained('kegiatans')->cascadeOnDelete();
            $table->foreignId('paket_id')->constrained('pakets')->cascadeOnDelete();
            $table->primary(['kegiatan_id', 'paket_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kegiatan_paket');
        Schema::dropIfExists('kegiatans');
    }
};