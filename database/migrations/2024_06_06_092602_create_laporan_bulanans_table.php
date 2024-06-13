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
            $table->foreignId('program_id')->references('id')->on('programs')->onDelete('cascade');
            $table->string('kode');
            $table->date('bulan_laporan');
            $table->foreignId('disusun_oleh')->nullable()->references('id')->on('users')->nullOnDelete();
            $table->foreignId('diperiksa_oleh')->nullable()->references('id')->on('users')->nullOnDelete();
            $table->timestamp('tanggal_pemeriksaan')->nullable();
            $table->timestamp('tanggal_pembuatan')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->softDeletes();
            $table->unique(['program_id', 'bulan_laporan']);
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
