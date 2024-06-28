<?php

namespace Database\Factories;

use App\Models\LaporanBulanan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PenerimaManfaat>
 */
class PenerimaManfaatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kategori' => fake()->word,
            'tipe_rutinitas' => fake()->word,
            'tipe_penyaluran' => fake()->word,
            'rencana' => fake()->numberBetween(1, 100),
            'realisasi' => fake()->numberBetween(1, 100),
            'id_laporan_bulanan' => LaporanBulanan::factory()->create()->id,
        ];
    }
}
