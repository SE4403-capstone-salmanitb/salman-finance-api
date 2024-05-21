<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\JudulKegiatanRKA;
use App\Models\Program;
use App\Models\ProgramKegiatanRKA;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JudulKegiatanRKAControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * index with no user authenticated
     */
    public function test_index_no_user(): void
    {
        $response = $this->getJson('/api/judulKegiatanRKA');

        $response->assertStatus(401);
    }

    /**
     * index with a user authenticated
     */
    public function test_index_with_user(): void
    {
        $user = User::factory()->create();
        $response = $this->getJson('/api/judulKegiatanRKA', [
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(200);
    }

    public function test_create_valid_input()
    {
        $user = User::factory()->create();
        $program = ProgramKegiatanRKA::factory()->for(program::factory())->create();

        $data = [
            'nama' => 'Test Program Kegiatan RKA',
            'id_program_kegiatan_rka' => $program->id,
        ];

        $response = $this->postJson('/api/judulKegiatanRKA', $data, 
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
            'id_program_kegiatan_rka' => -999,
        ];

        $response = $this->postJson('/api/judulKegiatanRKA', $data, 
        [
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(422);
    }

    public function test_show_no_user()
    {
        $judulKegiatanRKA = JudulKegiatanRKA::factory()
        ->for(ProgramKegiatanRKA::factory()
            ->for(Program::factory())
            ->create(), 'programKegiatan')
        ->create();
        $response = $this->getJson('/api/judulKegiatanRKA/'.$judulKegiatanRKA->id);

        $response->assertStatus(401);
    }

    public function test_show_with_user()
    {  
        $user = User::factory()->create();
        $program = JudulKegiatanRKA::factory()
        ->for(ProgramKegiatanRKA::factory()
            ->for(Program::factory())
            ->create(), 'programKegiatan')
        ->create();

        $data = [
            'id' => 101,
            'nama' => 'Test Program Kegiatan RKA',
            'id_program_kegiatan_rka' => $program->id,
        ];

        JudulKegiatanRKA::factory()->create($data);


        $response = $this->getJson('/api/judulKegiatanRKA/'.$data['id'],
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

        $judulKegiatanRKA = JudulKegiatanRKA::factory()
        ->for(ProgramKegiatanRKA::factory()
            ->for(Program::factory())
            ->create(), 'programKegiatan')
        ->create();


        $response = $this->patchJson('/api/judulKegiatanRKA/'.$judulKegiatanRKA->id,
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



        $response = $this->getJson('/api/judulKegiatanRKA/100001',
        [
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(404);
    }

    public function test_update_invalid_input()
    {
        $user = User::factory()->create();

        $judulKegiatanRKA = JudulKegiatanRKA::factory()
        ->for(ProgramKegiatanRKA::factory()
            ->for(Program::factory())
            ->create(), 'programKegiatan')
        ->create();

        $response = $this->patchJson('/api/judulKegiatanRKA/'.$judulKegiatanRKA->id,
        [
            'id_program_kegiatan_rka' => -999
        ],
        [
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(422);
    }

    public function test_update_not_found()
    {
        $user = User::factory()->create();

        $response = $this->patchJson('/api/judulKegiatanRKA/-99',
        [
            'id_program_kegiatan_rka' => -999
        ],
        [
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(404);
    }

    function test_delete_normal() 
    {
        $user = User::factory()->create();
        $judulKegiatanRKA =  JudulKegiatanRKA::factory()
        ->for(ProgramKegiatanRKA::factory()
            ->for(Program::factory())
            ->create(), 'programKegiatan')
        ->create();


        $response = $this->deleteJson('/api/judulKegiatanRKA/'.$judulKegiatanRKA->id,
        headers:[
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(204);
    }

    function test_delete_not_found() 
    {
        $user = User::factory()->create();


        $response = $this->deleteJson('/api/judulKegiatanRKA/-99',
        headers:[
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(404);
    }
}
