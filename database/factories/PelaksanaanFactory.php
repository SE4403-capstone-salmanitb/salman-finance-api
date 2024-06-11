<?php

namespace Database\Factories;

use App\Models\LaporanBulanan;
use App\Models\ProgramKegiatanKPI;
use Illuminate\Database\Eloquent\Factories\Factory;

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

            'id_program_kegiatan_kpi' => function() {
                $kpi = ProgramKegiatanKPI::first();
                if (!$kpi) {
                    $kpi = ProgramKegiatanKPI::factory()->create();
                }
                return $kpi->id;
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

    public function randomKPI(): static
    {
        return $this->state(function (array $attributes) {
            $laporan = LaporanBulanan::where("id", $attributes["id_laporan_bulanan"])->get();
            $kpis = ProgramKegiatanKPI::where("id_program", $laporan->id_program)->get();
            return [
                'id_program_kegiatan_kpi' => $kpis[fake()->numberBetween(0, count($kpis)-1)]->id
            ];
        });
    }
}
