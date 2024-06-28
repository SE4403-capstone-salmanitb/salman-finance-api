<?php

namespace Database\Factories;

use App\Models\KeyPerformanceIndicator;
use App\Models\LaporanBulanan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LaporanKPIBulanan>
 */
class LaporanKPIBulananFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $capaian = random_int(4, 10000);
        $d1 = random_int(1, $capaian-3);
        $d2 = random_int(1, $capaian-$d1-2);
        $d3 = random_int(1, $capaian-$d2-$d1-1);
        $d4 = $capaian-$d1-$d2-$d3;

        return [
            "capaian" => $capaian,
            "deskripsi" => sprintf(
                "%d %s, %d %s, %d %s, %d %s", 
                $d1, fake()->jobTitle, 
                $d2, fake()->jobTitle, 
                $d1, fake()->jobTitle, 
                $d4, fake()->jobTitle, 
            ),
            "id_kpi" => function() {
                $kpis = KeyPerformanceIndicator::first();
                if( ! $kpis ){
                    $kpis = KeyPerformanceIndicator::factory()->create();
                }
                return $kpis->id;
            },
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
