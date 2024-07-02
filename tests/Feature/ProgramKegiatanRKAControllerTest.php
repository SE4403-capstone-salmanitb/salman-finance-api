<?php

namespace Tests\Feature;

use App\Models\program;
use App\Models\ProgramKegiatanRKA;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProgramKegiatanRKAControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * index with no user authenticated
     */
    public function test_index_no_user(): void
    {
        $response = $this->getJson('/api/programKegiatanRKA');

        $response->assertStatus(401);
    }

    /**
     * index with a user authenticated
     */
    public function test_index_with_user(): void
    {
        $user = User::factory()->create();
        $response = $this->getJson('/api/programKegiatanRKA', [
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(200);
    }

    public function test_create_valid_input()
    {
        $user = User::factory()->create();
        $program = program::factory()->create();

        $data = [
            'nama' => 'Test Program Kegiatan RKA',
            'deskripsi' => 'This is a test description',
            'output' => 'Test output',
            'tahun' => 2024,
            'id_program' => $program->id,
        ];

        $response = $this->postJson('/api/programKegiatanRKA', $data, 
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
            'nama' => 'Test Program Kegiatan RKA',
            'deskripsi' => 'This is a test description',
            'output' => 'Test output',
            'tahun' => 2024,
            'id_program' => -999,
        ];

        $response = $this->postJson('/api/programKegiatanRKA', $data, 
        [
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(422);
    }

    public function test_show_no_user()
    {
        $programKegiatanRKA = ProgramKegiatanRKA::factory()->for(program::factory())->create();
        $response = $this->getJson('/api/programKegiatanRKA/'.$programKegiatanRKA->id);

        $response->assertStatus(401);
    }

    public function test_show_with_user()
    {  
        $user = User::factory()->create();
        $program = program::factory()->create();

        $data = [
            'id' => 111,
            'nama' => 'Test Program Kegiatan RKA',
            'deskripsi' => 'This is a test description',
            'output' => 'Test output',
            'tahun' => 2024,
            'id_program' => $program->id,
        ];

        ProgramKegiatanRKA::factory()->create($data);


        $response = $this->getJson('/api/programKegiatanRKA/'.$data['id'],
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

        $programKegiatanRKA = ProgramKegiatanRKA::factory()
        ->for(program::factory())
        ->create();


        $response = $this->patchJson('/api/programKegiatanRKA/'.$programKegiatanRKA->id,
        [
            'nama' => $newName
        ],
        [
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['nama' => $newName]);
    }

    public function test_show_not_found()
    {  
        $user = User::factory()->create();



        $response = $this->getJson('/api/programKegiatanRKA/100001',
        [
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(404);
    }

    public function test_update_invalid_input()
    {
        $user = User::factory()->create();

        $programKegiatanRKA = ProgramKegiatanRKA::factory()
        ->for(program::factory())
        ->create();

        $response = $this->patchJson('/api/programKegiatanRKA/'.$programKegiatanRKA->id,
        [
            'id_program' => -999
        ],
        [
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(422);
    }

    public function test_update_not_found()
    {
        $user = User::factory()->create();

        $programKegiatanRKA = ProgramKegiatanRKA::factory()
        ->for(program::factory())
        ->create();

        $response = $this->patchJson('/api/programKegiatanRKA/-99',
        [
            'id_program' => -999
        ],
        [
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(404);
    }

    function test_delete_normal() 
    {
        $user = User::factory()->create();
        $programKegiatanRKA =  ProgramKegiatanRKA::factory()->for(program::factory())->create();


        $response = $this->deleteJson('/api/programKegiatanRKA/'.$programKegiatanRKA->id,
        headers:[
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(204);
    }

    function test_delete_not_found() 
    {
        $user = User::factory()->create();


        $response = $this->deleteJson('/api/programKegiatanRKA/-99',
        headers:[
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(404);
    }
}
