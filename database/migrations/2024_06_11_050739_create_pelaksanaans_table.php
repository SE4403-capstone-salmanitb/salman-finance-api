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
        Schema::create('pelaksanaans', function (Blueprint $table) {
            $table->id();
            $table->text("penjelasan");
            $table->text("waktu");
            $table->text("tempat");
            $table->text("penyaluran");
            $table->foreignId('id_program_kegiatan_kpi')->nullable()->references('id')
                ->on('program_kegiatan_k_p_i_s')->cascadeOnDelete();
            $table->foreignId('id_laporan_bulanan')->references('id')
                ->on('laporan_bulanans')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelaksanaans');
    }
};
