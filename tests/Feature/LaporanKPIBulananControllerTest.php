<?php

namespace Tests\Feature;

use App\Models\KeyPerformanceIndicator;
use App\Models\LaporanBulanan;
use App\Models\LaporanKPIBulanan;
use App\Models\Program;
use App\Models\ProgramKegiatanKPI;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LaporanKPIBulananControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_index_filtered(): void
    {
        $user = User::factory()->create();
        $program = Program::factory()->create();
        $pkkpi = ProgramKegiatanKPI::factory()->createOne(["id_program" => $program->id]);
        $kpi = KeyPerformanceIndicator::factory()->createOne(["id_program_kegiatan_kpi" => $pkkpi->id]);
        $laporan = LaporanBulanan::factory()->createOne(["program_id" => $program->id, "disusun_oleh" => $user->id]);

        $data = [
            "id_laporan_bulanan" => $laporan->id,
            "id_kpi" => $kpi->id,
            "capaian" =>(string) 300,
            "deskripsi" => "100 John Doe, 100 Jane Doe, 100 Lainnya"
        ];

        LaporanKPIBulanan::factory()->create($data);
        $response = $this->actingAs($user)->get(
            '/api/laporanKPIBulanan?id_laporan_bulanan='.$data["id_laporan_bulanan"]
        );

        $response->assertStatus(200);
        $response->assertJsonFragment($data);
        $response->assertJsonCount(1);
    }

    public function test_index_no_filter(): void
    {
        $user = User::factory()->create();
        LaporanKPIBulanan::factory(2);

        $response = $this->actingAs($user)->get(
            '/api/laporanKPIBulanan'
        );
        $response->assertStatus(200);
    }

    public function test_create(): void
    {
        $user = User::factory()->create();
        $program = Program::factory()->create();
        $pkkpi = ProgramKegiatanKPI::factory()->createOne(["id_program" => $program->id]);
        $kpi = KeyPerformanceIndicator::factory()->createOne(["id_program_kegiatan_kpi" => $pkkpi->id]);
        $laporan = LaporanBulanan::factory()->createOne(["program_id" => $program->id, "disusun_oleh" => $user->id]);

        $data = [
            "id_laporan_bulanan" => $laporan->id,
            "id_kpi" => $kpi->id,
            "capaian" => (string) 300,
            "deskripsi" => "100 John Doe, 100 Jane Doe, 100 Lainnya"
        ];
        
        $response = $this->post(
            '/api/laporanKPIBulanan',
            $data,
            [
                "authorization" => "Bearer ".$user->createToken("test", ["user"])->plainTextToken

            ]
        );

        $response->assertCreated();
        $response->assertJsonFragment($data);
    }

    public function test_create_other_person(): void
    {
        $user = User::factory()->create();
        $user2 = User::factory()->createOne();
        $program = Program::factory()->create();
        $pkkpi = ProgramKegiatanKPI::factory()->createOne(["id_program" => $program->id]);
        $kpi = KeyPerformanceIndicator::factory()->createOne(["id_program_kegiatan_kpi" => $pkkpi->id]);
        $laporan = LaporanBulanan::factory()->createOne(["program_id" => $program->id, "disusun_oleh" => $user2->id]);

        
        $data = [
            "id_laporan_bulanan" => $laporan->id,
            "id_kpi" => $kpi->id,
            "capaian" =>(string) 300,
            "deskripsi" => "100 John Doe, 100 Jane Doe, 100 Lainnya"
        ];

        $response = $this->post(
            '/api/laporanKPIBulanan',
            $data,
            [
                "authorization" => "Bearer ".$user->createToken("", ["user"])->plainTextToken
            ]
        );

        $response->assertForbidden();
    }

    public function test_create_invalid_kpi(): void
    {
        $user = User::factory()->create();
        $program = Program::factory()->create();
        $program2 = Program::factory()->create();
        $pkkpi = ProgramKegiatanKPI::factory()->createOne(["id_program" => $program2->id]);
        $kpi = KeyPerformanceIndicator::factory()->createOne(["id_program_kegiatan_kpi" => $pkkpi->id]);
        $laporan = LaporanBulanan::factory()->createOne(["program_id" => $program->id, "disusun_oleh" => $user->id]);
        
        $data = [
            "id_laporan_bulanan" => $laporan->id,
            "id_kpi" => $kpi->id,
            "capaian" =>(string) 300,
            "deskripsi" => "100 John Doe, 100 Jane Doe, 100 Lainnya"
        ];
        
        $response = $this->postJson(
            '/api/laporanKPIBulanan',
            $data,
            [
                "authorization" => "Bearer ".$user->createToken("test", ["user"])->plainTextToken

            ]
        );

        $response->assertStatus(422);
    }

    public function test_get_one(): void
    {
        $user = User::factory()->create();
        $program = Program::factory()->create();
        $pkkpi = ProgramKegiatanKPI::factory()->createOne(["id_program" => $program->id]);
        $kpi = KeyPerformanceIndicator::factory()->createOne(["id_program_kegiatan_kpi" => $pkkpi->id]);
        $laporan = LaporanBulanan::factory()->createOne(["program_id" => $program->id, "disusun_oleh" => $user->id]);
        
        $data = [
            "id_laporan_bulanan" => $laporan->id,
            "id_kpi" => $kpi->id,
            "capaian" =>(string) 300,
            "deskripsi" => "100 John Doe, 100 Jane Doe, 100 Lainnya"
        ];

        $pel = LaporanKPIBulanan::factory()->create($data);

        $response = $this->actingAs($user)->get(
            '/api/laporanKPIBulanan/'.$pel->id
        );

        $response->assertOk();
        $response->assertJsonFragment($data);
    }

    public function test_delete(): void
    {
        $user = User::factory()->create();
        $program = Program::factory()->create();
        $pkkpi = ProgramKegiatanKPI::factory()->createOne(["id_program" => $program->id]);
        $kpi = KeyPerformanceIndicator::factory()->createOne(["id_program_kegiatan_kpi" => $pkkpi->id]);
        $laporan = LaporanBulanan::factory()->createOne(["program_id" => $program->id, "disusun_oleh" => $user->id]);
        
        $data = [
            "id_laporan_bulanan" => $laporan->id,
            "id_kpi" => $kpi->id,
            "capaian" =>(string) 300,
            "deskripsi" => "100 John Doe, 100 Jane Doe, 100 Lainnya"
        ];

        $pel = LaporanKPIBulanan::factory()->create($data);

        $response = $this->actingAs($user)->delete(
            '/api/laporanKPIBulanan/'.$pel->id
        );

        $response->assertNoContent();
    }

    public function test_update(): void
    {
        $user = User::factory()->create();
        $program = Program::factory()->create();
        $pkkpi = ProgramKegiatanKPI::factory()->createOne(["id_program" => $program->id]);
        $kpi = KeyPerformanceIndicator::factory()->createOne(["id_program_kegiatan_kpi" => $pkkpi->id]);
        $laporan = LaporanBulanan::factory()->createOne(["program_id" => $program->id, "disusun_oleh" => $user->id]);
        
        $data = [
            "capaian" =>(string) 300,
            "deskripsi" => "100 John Doe, 100 Jane Doe, 100 Lainnya"
        ];

        $pel = LaporanKPIBulanan::factory()->create([
            "id_laporan_bulanan" => $laporan->id,
            "id_kpi" => $kpi->id,
        ]);

        $response = $this->patch(
            '/api/laporanKPIBulanan/'.$pel->id,
            $data,
            [
                "authorization" => "Bearer ".$user->createToken("", ["user"])->plainTextToken
            ]
        );

        $response->assertOk();
        $response->assertJsonFragment($data);
    }

    public function test_update_wrong_kpi(): void
    {
        $user = User::factory()->create();
        $program = Program::factory()->create();
        $program2 = Program::factory()->create();
        $pkkpi = ProgramKegiatanKPI::factory()->createOne(["id_program" => $program->id]);
        $pkkpi2 = ProgramKegiatanKPI::factory()->createOne(["id_program" => $program2->id]);
        $kpi = KeyPerformanceIndicator::factory()->createOne(["id_program_kegiatan_kpi" => $pkkpi->id]);
        $kpi2 = KeyPerformanceIndicator::factory()->createOne(["id_program_kegiatan_kpi" => $pkkpi2->id]);
        $laporan = LaporanBulanan::factory()->createOne(["program_id" => $program->id, "disusun_oleh" => $user->id]);
        
        $data = [
            "capaian" =>(string) 300,
            "deskripsi" => "100 John Doe, 100 Jane Doe, 100 Lainnya",
            "id_kpi" => $kpi2->id
        ];

        $pel = LaporanKPIBulanan::factory()->create([
            "id_laporan_bulanan" => $laporan->id,
            "id_kpi" => $kpi->id,
        ]);

        $response = $this->patch(
            '/api/laporanKPIBulanan/'.$pel->id,
            $data,
            [
                "authorization" => "Bearer ".$user->createToken("", ["user"])->plainTextToken
            ]
        );

        $response->assertStatus(422);
    }

    public function test_update_wrong_laporan(): void
    {
        $user = User::factory()->create();
        $program = Program::factory()->create();
        $program2 = Program::factory()->create();
        $pkkpi = ProgramKegiatanKPI::factory()->createOne(["id_program" => $program->id]);
        $kpi = KeyPerformanceIndicator::factory()->createOne(["id_program_kegiatan_kpi" => $pkkpi->id]);
        $laporan = LaporanBulanan::factory()->createOne(["program_id" => $program->id, "disusun_oleh" => $user->id]);
        $laporan2 = LaporanBulanan::factory()->createOne(["program_id" => $program2->id, "disusun_oleh" => $user->id]);
        
        $data = [
            "capaian" =>(string) 300,
            "deskripsi" => "100 John Doe, 100 Jane Doe, 100 Lainnya",
            "id_laporan_bulanan" => $laporan2->id
        ];

        $pel = LaporanKPIBulanan::factory()->create([
            "id_laporan_bulanan" => $laporan->id,
            "id_kpi" => $kpi->id,
        ]);

        $response = $this->patch(
            '/api/laporanKPIBulanan/'.$pel->id,
            $data,
            [
                "authorization" => "Bearer ".$user->createToken("", ["user"])->plainTextToken
            ]
        );

        $response->assertStatus(422);
    }
}
