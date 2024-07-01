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
        Schema::create('danas', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_pengeluaran');
            $table->integer('jumlah')->nullable()->default(0);
            $table->integer('ras')->nullable()->default(0);
            $table->integer('kepesertaan')->nullable()->default(0);
            $table->integer('dpk')->nullable()->default(0);
            $table->integer('pusat')->nullable()->default(0);
            $table->integer('wakaf')->nullable()->default(0);
            $table->foreignId('id_laporan_bulanan')->references('id')
                ->on('laporan_bulanans')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['is_pengeluaran', 'id_laporan_bulanan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('danas');
    }
};
