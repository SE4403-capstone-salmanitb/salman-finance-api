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
        Schema::create('item_kegiatan_r_k_a_s', function (Blueprint $table) {
            $table->id();
            $table->string('uraian');
            $table->integer('nilai_satuan');
            $table->integer('quantity');
            $table->string('quantity_unit');
            $table->integer('frequency');
            $table->string('frequency_unit');
            $table->string('sumber_dana');

            $table->boolean('dana_jan')->default(0);
            $table->boolean('dana_feb')->default(0);
            $table->boolean('dana_mar')->default(0);
            $table->boolean('dana_apr')->default(0);
            $table->boolean('dana_mei')->default(0);
            $table->boolean('dana_jun')->default(0);
            $table->boolean('dana_jul')->default(0);
            $table->boolean('dana_aug')->default(0);
            $table->boolean('dana_sep')->default(0);
            $table->boolean('dana_oct')->default(0);
            $table->boolean('dana_nov')->default(0);
            $table->boolean('dana_dec')->default(0);

            $table->foreignId('id_judul_kegiatan')->references('id')->on('judul_kegiatan_r_k_a_s')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_kegiatan_r_k_a_s');
    }
};
