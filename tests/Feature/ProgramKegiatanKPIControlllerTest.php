<?php

namespace Tests\Feature;

use App\Models\Program;
use App\Models\ProgramKegiatanKPI;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProgramKegiatanKPIControlllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * index with no user authenticated
     */
    public function test_index_no_user(): void
    {
        $response = $this->getJson('/api/programKegiatanKPI');

        $response->assertStatus(401);
    }

    /**
     * index with a user authenticated
     */
    public function test_index_with_user(): void
    {
        $user = User::factory()->create();
        $response = $this->getJson('/api/programKegiatanKPI', [
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(200);
    }

    public function test_create_valid_input()
    {
        $user = User::factory()->create();
        $program = Program::factory()->create();

        $data = [
            'nama' => 'Test Program Kegiatan KPI',
            'tahun' => 2024,
            'id_program' => $program->id,
        ];

        $response = $this->postJson('/api/programKegiatanKPI', $data, 
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
            'nama' => 'Test Program Kegiatan KPI',
            'tahun' => 1745,
            'id_program' => -999,
        ];

        $response = $this->postJson('/api/programKegiatanKPI', $data, 
        [
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(422);
    }

    public function test_show_with_user()
    {  
        $user = User::factory()->create();
        $program = program::factory()->create();

        $data = [
            'id' => 111+random_int(0, 100), // prevent id conflict when running multiple tests
            'nama' => 'Test Program Kegiatan KPI',
            'tahun' => 2024,
            'id_program' => $program->id,
        ];

        ProgramKegiatanKPI::factory()->create($data);


        $response = $this->getJson('/api/programKegiatanKPI/'.$data['id'],
        [
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(200);
        $response->assertjson($data);
    }

    public function test_update_valid_input()
    {
        $user = User::factory()->create();
        $newName = "This is the new name";

        $programKegiatanKPI = ProgramKegiatanKPI::factory()
        ->for(program::factory())
        ->create();


        $response = $this->patchJson('/api/programKegiatanKPI/'.$programKegiatanKPI->id,
        [
            'nama' => $newName
        ],
        [
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['nama' => $newName]);
    }

    public function test_update_invalid_input()
    {
        $user = User::factory()->create();

        $programKegiatanKPI = ProgramKegiatanKPI::factory()
        ->for(program::factory())
        ->create();

        $response = $this->patchJson('/api/programKegiatanKPI/'.$programKegiatanKPI->id,
        [
            'id_program' => -999
        ],
        [
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(422);
    }

    function test_delete_normal() 
    {
        $user = User::factory()->create();
        $programKegiatanKPI =  ProgramKegiatanKPI::factory()->for(program::factory())->create();


        $response = $this->deleteJson('/api/programKegiatanKPI/'.$programKegiatanKPI->id,
        headers:[
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(204);
    }
}
