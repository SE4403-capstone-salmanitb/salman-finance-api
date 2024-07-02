<?php

namespace Database\Factories;

use App\Models\Program;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LaporanBulanan>
 */
class LaporanBulananFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode' => fake()->hexColor,
            'bulan_laporan' => fake()->unique()->date('Y-m-01'),

            'program_id' => function() {
                $program = Program::first();
                if (!$program) {
                    $program = Program::factory()->create();
                }
                return $program->id;
            },

            'disusun_oleh' => function() {
                $user = User::first();
                if (!$user) {
                    $user = User::factory()->create();
                }
                return $user->id;
            },
        ];
    }

    public function verified(): static
    {
        return $this->state(function (array $attributes) {
            $users = User::all();
            if ( $attributes['disusun_oleh'] === $users->last()->id || $users->count() < 2){
                $user = User::factory()->create();
            } else {
                $user = $users->last();
            }
            return [
                'diperiksa_oleh' => $user->id,
                'tanggal_pemeriksaan' => now()
            ];
        });
    }
}
