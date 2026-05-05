<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buku_tukars', function (Blueprint $table) {
            $table->id();
            $table->string('isbn')->nullable();
            $table->string('judul');
            $table->string('pengarang')->nullable();
            $table->string('penerbit')->nullable();
            $table->enum('kondisi', ['baik', 'cukup', 'rusak']);
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['menunggu', 'diterima', 'ditolak', 'sudah_ditukar'])->default('menunggu');
            $table->foreignId('member_id')->constrained('members')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku_tukars');
    }
};