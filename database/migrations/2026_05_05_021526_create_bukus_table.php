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
            $table->text('deskripsi')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->foreignId('paket_id')->nullable()->constrained('pakets')->nullOnDelete();
            $table->foreignId('lokasi_id')->nullable()->constrained('lokasis')->nullOnDelete();
            $table->foreignId('member_id')->nullable()->constrained('members')->nullOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['isbn', 'lokasi_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};