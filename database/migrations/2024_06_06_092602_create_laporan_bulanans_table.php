<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporan_bulanans', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nama');
            $table->string('kode');
            $table->date('bulanLaporan');
            $table->foreignId('disusun_oleh')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('diperiksa_oleh')->references('id')->on('users')->onDelete('cascade');
            $table->timestamp('tanggal_pemeriksaan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_bulanans');
    }
};
