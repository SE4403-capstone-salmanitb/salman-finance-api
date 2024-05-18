<?php

namespace Database\Factories;

use App\Models\ProgramKegiatanRKA;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JudulKegiatanRKA>
 */
class JudulKegiatanRKAFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->regexify('[a-z]').". ".fake()->text(),
            'id_program_kegiatan_rka' => function() {
                $prokegRKA = ProgramKegiatanRKA::first();
                if (!$prokegRKA) {
                    $prokegRKA = ProgramKegiatanRKA::factory()->create();
                }
                return $prokegRKA->id;
            }
        ];
    }
}
