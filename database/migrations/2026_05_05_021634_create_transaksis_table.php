<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->cascadeOnDelete();
            $table->foreignId('paket_id')->constrained('pakets')->cascadeOnDelete();
            $table->foreignId('buku_diserahkan_id')->constrained('buku_eksemplars')->cascadeOnDelete();
            $table->foreignId('buku_diterima_id')->constrained('buku_eksemplars')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('catatan_petugas')->nullable();
            $table->timestamp('tanggal_tukar')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};