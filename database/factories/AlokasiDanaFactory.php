<?php

namespace Database\Factories;

use App\Models\ItemKegiatanRKA;
use App\Models\LaporanBulanan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AlokasiDana>
 */
class AlokasiDanaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_laporan_bulanan' => LaporanBulanan::factory()->createOne()->id,
            'id_item_rka' => ItemKegiatanRKA::factory()->createOne()->id,
            'jumlah_realisasi' => fake()->numberBetween(0, 99999)
        ];
    }
}
