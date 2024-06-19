<?php

namespace Tests\Feature;

use App\Models\LaporanBulanan;
use App\Models\Pelaksanaan;
use App\Models\Program;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PelaksanaanControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_index_filtered(): void
    {
        $user = User::factory()->create();
        $program = Program::factory()->create();
        Pelaksanaan::factory(5, ["program_id" => $program->id]);

        
        $data = [
            "id_laporan_bulanan" => LaporanBulanan::factory()->create()->id,
            "penjelasan" => "halo halo bandung",
            "waktu" => "ibu kota periangan",
            "tempat" => "sudah lama beta",
            "penyaluran" => "tidak berjumpa dengan kau"
        ];

        Pelaksanaan::factory()->create($data);
        $response = $this->actingAs($user)->get(
            '/api/pelaksanaan?id_laporan_bulanan='.$data["id_laporan_bulanan"].
            "&penyaluran=".$data['penyaluran']
        );

        $response->assertStatus(200);
        $response->assertJsonFragment($data);
        $response->assertJsonCount(1);
    }

    public function test_index_no_filter(): void
    {
        $user = User::factory()->create();
        Pelaksanaan::factory(2);

        $response = $this->actingAs($user)->get(
            '/api/pelaksanaan'
        );
        $response->assertStatus(200);
    }

    public function test_create(): void
    {
        $program = Program::factory()->create();
        $user = User::factory()->create();
        $lap = LaporanBulanan::factory()->create([
            "program_id" => $program->id,
            "disusun_oleh" => $user->id
        ]);

        $data = [
            "id_laporan_bulanan" => $lap->id,
            "penjelasan" => "halo halo bandung",
            "waktu" => "ibu kota periangan",
            "tempat" => "sudah lama beta",
            "penyaluran" => "tidak berjumpa dengan kau"
        ];
        
        $response = $this->post(
            '/api/pelaksanaan',
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
        $p = Program::factory()->create();
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $lap = LaporanBulanan::factory()->create([
            "program_id" => $p->id,
            "disusun_oleh" => $user2->id
        ]);

        
        $data = [
            "id_laporan_bulanan" => $lap->id,
            "penjelasan" => "halo halo bandung",
            "waktu" => "ibu kota periangan",
            "tempat" => "sudah lama beta",
            "penyaluran" => "tidak berjumpa dengan kau"
        ];

        $response = $this->post(
            '/api/pelaksanaan',
            $data,
            [
                "authorization" => "Bearer ".$user->createToken("", ["user"])->plainTextToken
            ]
        );

        $response->assertForbidden();
    }
}
