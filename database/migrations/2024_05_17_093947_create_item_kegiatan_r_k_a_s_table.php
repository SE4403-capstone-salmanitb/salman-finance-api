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
            $table->text('uraian');
            $table->text('nilai_satuan');
            $table->text('quantity');
            $table->text('quantity_unit');
            $table->text('frequency');
            $table->text('frequency_unit');
            $table->string('sumber_dana');

            $table->text('dana_jan')->default(0);
            $table->text('dana_feb')->default(0);
            $table->text('dana_mar')->default(0);
            $table->text('dana_apr')->default(0);
            $table->text('dana_mei')->default(0);
            $table->text('dana_jun')->default(0);
            $table->text('dana_jul')->default(0);
            $table->text('dana_aug')->default(0);
            $table->text('dana_sep')->default(0);
            $table->text('dana_oct')->default(0);
            $table->text('dana_nov')->default(0);
            $table->text('dana_dec')->default(0);

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
