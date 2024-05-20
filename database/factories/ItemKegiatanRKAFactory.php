<?php

namespace Database\Factories;

use App\Models\JudulKegiatanRKA;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ItemKegiatanRKA>
 */
class ItemKegiatanRKAFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $freq = fake()->numberBetween(1, 12);

        $bool_array = array_fill_keys(array('dana_jan', 'dana_feb', 'dana_mar', 'dana_apr', 'dana_mei', 'dana_jun', 'dana_jul', 'dana_aug', 'dana_sep', 'dana_oct', 'dana_nov', 'dana_dec'), False);

        // Randomly set some elements to True so that the total number of True values is equal to rand_num
        $keys = array_rand($bool_array, $freq);
        foreach ((array)$keys as $key) {
            $bool_array[$key] = True;
        }

        return array_merge([
            'uraian' => fake()->sentence(2),
            'nilai_satuan' => fake()->numberBetween(10, 20000)*100,
            'quantity' => fake()->numberBetween(1, 100),
            'quantity_unit' => "org",
            'frequency' => $freq,
            'frequency_unit' => "bln",
            'sumber_dana' => fake()->randomElement(['Pusat', 'RAS', 'Kepesertaan', 'Pihak Ketiga', 'Wakaf Salman']),

            'id_judul_kegiatan' => function() {
                $judul = JudulKegiatanRKA::first();
                if (!$judul) {
                    $judul = JudulKegiatanRKA::factory()->create();
                }
                return $judul->id;
            }
        ], $bool_array);
    }
}
