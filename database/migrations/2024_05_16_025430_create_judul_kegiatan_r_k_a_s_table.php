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
        Schema::create('judul_kegiatan_r_k_a_s', function (Blueprint $table) {
            $table->id();
            $table->text('nama');
            $table->foreignId('id_program_kegiatan_rka')->references('id')
                ->on('program_kegiatan_r_k_a_s')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('judul_kegiatan_r_k_a_s');
    }
};
