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
        Schema::create('program_kegiatan_r_k_a_s', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('deskripsi');
            $table->string('output');
            $table->integer('tahun');

            $table->integer('sumber_dana_pusat');
            $table->integer('sumber_dana_ras');
            $table->integer('sumber_dana_kepesertaan');
            $table->integer('sumber_dana_pihak_ketiga');
            $table->integer('sumber_dana_pusat_wakaf_salman');

            $table->timestamps();
            $table->foreignId('id_program')->references('id')->on('programs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_kegiatan_r_k_a_s');
    }
};
