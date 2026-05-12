<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('pengarang');
            $table->string('penerbit')->nullable();
            $table->string('isbn')->nullable();
            $table->integer('tahun_terbit')->nullable();
            $table->string('tempat_terbit')->nullable();
            $table->text('resume')->nullable();
            $table->unsignedInteger('stok')->default(0);
            $table->string('kategori')->nullable();
            $table->enum('sumber', ['perpus', 'tukar'])->default('perpus');
            $table->enum('kondisi', ['baik', 'cukup', 'rusak'])->nullable();
            $table->text('deskripsi')->nullable();
            $table->foreignId('lokasi_id')->nullable()->constrained('lokasis')->nullOnDelete();
            $table->foreignId('member_id')->nullable()->constrained('members')->nullOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};