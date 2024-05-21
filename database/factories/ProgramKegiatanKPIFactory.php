<?php

namespace Database\Factories;

use App\Models\Program;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProgramKegiatanKPI>
 */
class ProgramKegiatanKPIFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => 'produksi_'.fake()->name(),
            'tahun' => now()->year,

            'id_program' => function() {
                $program = Program::first();
                if (!$program) {
                    $program = Program::factory()->create();
                }
                return $program->id;
            }

        ];
    }
}
