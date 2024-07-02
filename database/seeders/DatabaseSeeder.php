<?php

namespace Database\Seeders;

use App\Models\ItemKegiatanRKA;
use App\Models\JudulKegiatanRKA;
use App\Models\KeyPerformanceIndicator;
use App\Models\LaporanBulanan;
use App\Models\LaporanKPIBulanan;
use App\Models\Pelaksanaan;
use App\Models\PenerimaManfaat;
use App\Models\User;
use App\Models\program;
use App\Models\ProgramKegiatanKPI;
use App\Models\ProgramKegiatanRKA;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

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
                    LaporanBulanan::factory()->verified()->count(1),
                    "LaporanBulanan"
                )
                ->has( // not verified
                    LaporanBulanan::factory(state: ["bulan_laporan"=>now()->format('Y-m-01')])
                    ->has(
                        Pelaksanaan::factory()->count(4),
                        "pelaksanaans"
                    )
                    ->has(
                        PenerimaManfaat::factory()->count(5),
                        "penerimaManfaats"
                    )
                    ->count(1),
                    "LaporanBulanan"
                )
                ->create([
                    'nama' => $value
                ]);
            }
        }
        
        foreach (Pelaksanaan::all() as $pelaksanaan) {
            $kpis = ProgramKegiatanKPI::where(
                "id_program", 
                $pelaksanaan->laporanBulanan->program_id)
            ->where(
                "tahun",
                $pelaksanaan->laporanBulanan->bulan_laporan->year
            )
            ->get();
            $pelaksanaan->updateQuietly([
                "id_program_kegiatan_kpi" => $kpis[random_int(0, count($kpis)-1)]->id
            ]);
        }

        $laporans = LaporanBulanan::query()
        ->where("bulan_laporan", now()->format('Y-m-01'))
        ->where("diperiksa_oleh", null)
        ->get();

        $kpis = KeyPerformanceIndicator::query()
        ->whereHas("programKegiatan", function ($q) {
            return $q->where("tahun", now()->year);
        })
        ->get()->load("programKegiatan");

        foreach ($laporans as $laporan) {
            foreach ($kpis as $kpi) {
                if ($laporan->program_id === $kpi->programKegiatan->id_program){
                    LaporanKPIBulanan::factory()->create([
                        "id_laporan_bulanan" => $laporan->id,
                        "id_kpi" => $kpi->id
                    ]);
                }
            }
        }

    }
}
