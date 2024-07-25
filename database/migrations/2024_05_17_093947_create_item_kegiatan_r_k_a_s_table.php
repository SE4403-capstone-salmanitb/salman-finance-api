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

            $table->text('dana_jan');
            $table->text('dana_feb');
            $table->text('dana_mar');
            $table->text('dana_apr');
            $table->text('dana_mei');
            $table->text('dana_jun');
            $table->text('dana_jul');
            $table->text('dana_aug');
            $table->text('dana_sep');
            $table->text('dana_oct');
            $table->text('dana_nov');
            $table->text('dana_dec');

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
