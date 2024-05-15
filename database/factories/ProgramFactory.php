<?php

namespace Database\Factories;

use App\Models\program;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\program>
 */
class programFactory extends Factory
{
    protected $model = program::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'nama' => fake()->userName

        ];
    }
}
