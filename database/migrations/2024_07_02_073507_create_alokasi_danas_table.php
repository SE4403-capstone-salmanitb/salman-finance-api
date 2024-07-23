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
        Schema::create('alokasi_danas', function (Blueprint $table) {
            $table->id();
            $table->text('jumlah_realisasi')->default('0');
            $table->foreignId('id_laporan_bulanan')->references('id')
                ->on('laporan_bulanans')->cascadeOnDelete();
            $table->foreignId('id_item_rka')->references('id')
                ->on('item_kegiatan_r_k_a_s')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['id_laporan_bulanan', 'id_item_rka']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alokasi_danas');
    }
};
