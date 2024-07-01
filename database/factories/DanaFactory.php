<?php

namespace Database\Factories;

use App\Models\LaporanBulanan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dana>
 */
class DanaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'is_pengeluaran' => fake()->boolean(),
            'jumlah' => fake()->numberBetween(50000, 12000000),
            'ras' => fake()->numberBetween(50000, 12000000),
            'kepesertaan' => fake()->numberBetween(50000, 12000000),
            'dpk' => fake()->numberBetween(50000, 12000000),
            'pusat' => fake()->numberBetween(50000, 12000000),
            'wakaf' => fake()->numberBetween(50000, 12000000),
            'id_laporan_bulanan' => LaporanBulanan::factory()->createOne()->id
        ];
    }
}
