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
            $table->string('isbn')->nullable()->unique();
            $table->integer('tahun_terbit')->nullable();
            $table->string('tempat_terbit')->nullable();
            $table->text('resume')->nullable();
            $table->string('cover')->nullable();
            $table->string('kategori')->nullable();
            $table->text('deskripsi')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('buku_eksemplars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buku_id')->constrained('bukus')->cascadeOnDelete();
            $table->foreignId('paket_id')->nullable()->constrained('pakets')->nullOnDelete();
            $table->unsignedInteger('stok')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku_eksemplars');
        Schema::dropIfExists('bukus');
    }
};