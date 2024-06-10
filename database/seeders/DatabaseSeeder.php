<?php

namespace Database\Seeders;

use App\Models\ItemKegiatanRKA;
use App\Models\JudulKegiatanRKA;
use App\Models\KeyPerformanceIndicator;
use App\Models\LaporanBulanan;
use App\Models\User;
use App\Models\program;
use App\Models\ProgramKegiatanKPI;
use App\Models\ProgramKegiatanRKA;
use Illuminate\Auth\Events\Verified;
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
            'email' => 'test.user@example.com',
            'is_admin' => false,
        ]);

        User::factory()->create([
            'name' => 'Test admin',
            'email' => 'test@example.com',
            'is_admin' => true,
        ]);

        $programs = [
            'PROGRAM KEPUSTAKAAN', 
            'PROGRAM INTELEKTUALITAS', 
            'PROGRAM EKOLITERASI',
            'PROGRAM SUPPORTING SYSTEM'
        ];

        if (config('app.debug') == false) {
            foreach ($programs as $value) {
                program::factory()->create([
                    'nama' => $value
                ]);
            }
        } else {
            foreach ($programs as $value) {
                program::factory()
                ->has(
                    ProgramKegiatanRKA::factory()
                    ->has(
                        JudulKegiatanRKA::factory()->has(
                            ItemKegiatanRKA::factory()->count(2),
                            'item'
                        )
                        ->count(2),
                        "judul"
                    )
                    ->count(2), 
                    'programKegiatanRKA'
                )
                ->has(
                    ProgramKegiatanKPI::factory()->has(
                        KeyPerformanceIndicator::factory()->count(2),
                        'kpi'
                    )
                    ->count(2),
                    "programKegiatanKPI"
                )
                ->has( // verified
                    LaporanBulanan::factory()->verified()->count(3),
                    "LaporanBulanan"
                )
                ->has( // not verified
                    LaporanBulanan::factory(state: ["bulan_laporan"=>now()])->count(1),
                    "LaporanBulanan"
                )
                ->create([
                    'nama' => $value
                ]);
            }
        }
        
    }
}
