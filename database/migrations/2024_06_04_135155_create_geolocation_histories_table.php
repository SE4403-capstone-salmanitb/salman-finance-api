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
        Schema::create('geolocation_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('ip');
            $table->text('latitude')->nullable();
            $table->text('longitude')->nullable();
            $table->text('countryName')->nullable();
            $table->text('countryCode')->nullable();
            $table->text('regionCode')->nullable();
            $table->text('regionName')->nullable();
            $table->text('cityName')->nullable();
            $table->text('timezone')->nullable();
            $table->text('driver')->nullable();
            $table->text('is_authorized');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('geolocation_history');
    }
};
