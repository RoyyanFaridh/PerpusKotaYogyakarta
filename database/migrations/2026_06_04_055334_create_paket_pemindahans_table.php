<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paket_pemindahans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paket_id')->constrained('pakets')->cascadeOnDelete();
            $table->foreignId('lokasi_asal_id')->nullable()->constrained('lokasis')->nullOnDelete();
            $table->foreignId('lokasi_tujuan_id')->constrained('lokasis')->restrictOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('catatan')->nullable();
            $table->timestamp('dipindah_pada');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paket_pemindahans');
    }
};
