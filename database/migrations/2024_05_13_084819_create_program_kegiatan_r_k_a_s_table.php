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

            $table->integer('sumber_dana_pusat')->default(0);
            $table->integer('sumber_dana_ras')->default(0);
            $table->integer('sumber_dana_kepesertaan')->default(0);
            $table->integer('sumber_dana_pihak_ketiga')->default(0);
            $table->integer('sumber_dana_wakaf_salman')->default(0);

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
