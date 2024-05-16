<?php

namespace Database\Seeders;

use App\Models\JudulKegiatanRKA;
use App\Models\User;
use App\Models\program;
use App\Models\ProgramKegiatanRKA;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'is_admin' => true,
        ]);

        $programs = [
            'PROGRAM KEPUSTAKAAN', 
            'PROGRAM INTELEKTUALITAS', 
            'PROGRAM EKOLITERASI',
            'PROGRAM SUPPORTING SYSTEM'
        ];

        foreach ($programs as $value) {
            program::factory()
            ->has(
                ProgramKegiatanRKA::factory()
                ->has(
                    JudulKegiatanRKA::factory()->count(2),
                    "judul"
                )
                ->count(2), 
                'programKegiatanRKA'
            )
            ->create([
                'nama' => $value
            ]);
        }
    }
}
