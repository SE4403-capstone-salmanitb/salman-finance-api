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
        Schema::create('penerima_manfaats', function (Blueprint $table) {
            $table->id();
            $table->text('kategori')->nullable();
            $table->text('tipe_rutinitas')->nullable();
            $table->text('tipe_penyaluran')->nullable();
            $table->text('rencana')->nullable()->default(0);
            $table->text('realisasi')->nullable()->default(0);
            $table->foreignId('id_laporan_bulanan')->references('id')
                ->on('laporan_bulanans')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penerima_manfaats');
    }
};
