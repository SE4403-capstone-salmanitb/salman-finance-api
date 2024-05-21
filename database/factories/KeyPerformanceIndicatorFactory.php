<?php

namespace Database\Factories;

use App\Models\ProgramKegiatanKPI;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KeyPerformanceIndicator>
 */
class KeyPerformanceIndicatorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'indikator' => "Jumlah ".fake()->word(),
            'target' => "Minimal ".fake()->numberBetween(1, 10000)." item per bulan",
            'id_program_kegiatan_kpi' => function() {
                $prokegKPI = ProgramKegiatanKPI::first();
                if (!$prokegKPI) {
                    $prokegKPI = ProgramKegiatanKPI::factory()->create();
                }
                return $prokegKPI->id;
            }
        ];
    }
}
