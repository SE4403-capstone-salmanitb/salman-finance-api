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
            $table->text('nama');
            $table->text('deskripsi');
            $table->text('output');
            $table->text('tahun');
            $table->foreignId('id_program')->references('id')->on('programs')->onDelete('cascade');
            $table->timestamps();
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
