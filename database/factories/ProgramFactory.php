<?php

namespace Database\Factories;

use App\Models\Bidang;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\program>
 */
class ProgramFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'nama' => fake()->userName,
            'id_bidang' => function() {
                $program = Bidang::first();
                if (!$program) {
                    $program = Bidang::factory()->create();
                }
                return $program->id;
            },
        ];
    }
}
