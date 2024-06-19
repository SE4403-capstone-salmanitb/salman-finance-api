<?php

namespace Tests\Feature;

use App\Models\LaporanBulanan;
use App\Models\Pelaksanaan;
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
        Pelaksanaan::factory(20);

        
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
        $user = User::factory()->create();
        
        $data = [
            "id_laporan_bulanan" => LaporanBulanan::factory()->create()->id,
            "penjelasan" => "halo halo bandung",
            "waktu" => "ibu kota periangan",
            "tempat" => "sudah lama beta",
            "penyaluran" => "tidak berjumpa dengan kau"
        ];

        $response = $this->actingAs($user)->post(
            '/api/pelaksanaan',
            $data
        );

        $response->assertCreated();
        $response->assertJsonFragment($data);
    }

    public function test_create_other_person(): void
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        
        $data = [
            "id_laporan_bulanan" => LaporanBulanan::factory()
                ->create(["disusun_oleh" => $user2->id])->id,
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
