<?php

namespace Database\Factories;

use App\Models\LaporanBulanan;
use App\Models\ProgramKegiatanKPI;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pelaksanaan>
 */
class PelaksanaanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "penjelasan" => fake()->words(2, asText: true),
            "waktu" => "Senin-Jumat 09.00 - 17.00 WIB",
            "tempat" => fake()->city(),
            "penyaluran" => "Dakwah-Advokasi",
            "id_laporan_bulanan" => function() {
                $laporan = LaporanBulanan::first();
                if( ! $laporan ){
                    $laporan = LaporanBulanan::factory()->create();
                }
                return $laporan->id;
            }
        ];
    }
}
