<?php

namespace Tests\Feature\Mobile;

use App\Models\LaporanBulanan;
use App\Models\Program;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SeeLaporanBulananControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_see_laporan(): void
    {
        $time = now();
        $program = Program::factory()->createOne();
        $laporan = LaporanBulanan::factory()->createOne([
            'program_id' => $program->id,
            'bulan_laporan' => $time
        ]);

        $response = $this->get("/api/mobile/laporan?year={$time->year}&month={$time->month}&id_program={$program->id}");

        $response->assertStatus(200);
    }
}
