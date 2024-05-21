<?php

namespace Tests\Feature;

use App\Models\KeyPerformanceIndicator;
use App\Models\ProgramKegiatanKPI;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class KPIControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * index with a user authenticated
     */
    public function test_index_with_user(): void
    {
        $user = User::factory()->create();
        $response = $this->getJson('/api/keyPerformanceIndicator', [
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(200);
    }

    public function test_create_valid_input()
    {
        $user = User::factory()->create();
        $program = ProgramKegiatanKPI::factory()->create();

        $data = [
            'indikator' => 'Jumlah sebuah barang',
            'target' => 'Sekian jumlah per waktu',
            'id_program_kegiatan_kpi' => $program->id,
        ];

        $response = $this->postJson('/api/keyPerformanceIndicator', $data, 
        [
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(201);
        $response->assertjson($data);
    }

    public function test_create_invalid_input()
    {
        $user = User::factory()->create();

        $data = [
            'indikator' => 'Jumlah sebuah barang',
            'target' => 'Sekian jumlah per tahun',
        ];

        $response = $this->postJson('/api/keyPerformanceIndicator', $data, 
        [
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(422);
    }

    public function test_show_with_user()
    {  
        $user = User::factory()->create();
        $program = KeyPerformanceIndicator::factory()
        ->create();

        $data = [
            'id' => 9901 + random_int(0, 100),
            'indikator' => 'Jumlah sebuah barang',
            'target' => 'Sekian jumlah per waktu',
            'id_program_kegiatan_kpi' => $program->id,
        ];

        KeyPerformanceIndicator::factory()->create($data);


        $response = $this->getJson('/api/keyPerformanceIndicator/'.$data['id'],
        [
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(200);
        $response->assertjson($data);
    }

    public function test_update_valid_input()
    {
        $user = User::factory()->create();
        $newName = "5000 orang per tahun";

        $keyPerformanceIndicator = KeyPerformanceIndicator::factory()
        ->create();


        $response = $this->patchJson('/api/keyPerformanceIndicator/'.$keyPerformanceIndicator->id,
        [
            'target' => $newName
        ],
        [
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['target' => $newName]);
    }

    public function test_update_invalid_input()
    {
        $user = User::factory()->create();

        $keyPerformanceIndicator = KeyPerformanceIndicator::factory()
        ->create();

        $response = $this->patchJson('/api/keyPerformanceIndicator/'.$keyPerformanceIndicator->id,
        [
            'id_program_kegiatan_kpi' => -999,
            'indikator' => str_repeat("Lorem ipsum dolor sit amet", 52) // MAX 255 char
        ],
        [
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(422);
    }


    function test_delete_normal() 
    {
        $user = User::factory()->create();
        $keyPerformanceIndicator =  KeyPerformanceIndicator::factory()
        ->create();


        $response = $this->deleteJson('/api/keyPerformanceIndicator/'.$keyPerformanceIndicator->id,
        headers:[
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(204);
    }

}
