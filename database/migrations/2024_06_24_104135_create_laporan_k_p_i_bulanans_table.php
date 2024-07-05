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
        Schema::create('laporan_k_p_i_bulanans', function (Blueprint $table) {
            $table->id();
            $table->text('capaian')->nullable();
            $table->text('deskripsi')->nullable();
            $table->foreignId('id_kpi')->nullable()->references('id')
                ->on('key_performance_indicators')->cascadeOnDelete();
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
        Schema::dropIfExists('laporan_k_p_i_bulanans');
    }
};
