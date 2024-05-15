<?php

namespace Tests\Feature;

use App\Models\program;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProgramTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_program_index_unauthorized(): void
    {
        $response = $this->getJson('/api/program');

        $response->assertStatus(401);
    }

    public function test_program_index_non_admin(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('')->plainTextToken;
        $response = $this->getJson('/api/program', [
            'authorization' => "Bearer $token"
        ]);

        $response->assertStatus(200);
    }

    public function test_program_store_unauthorized(): void
    {
        //$user = User::factory()->create();


        $response = $this->postJson('/api/program',
            [
                'nama' => fake()->name()
            ]
        );

        $response->assertStatus(401);
    }

    public function test_program_store_non_admin(): void
    {
        $user = User::factory()->create();


        $response = $this->postJson('/api/program',
            [
                'nama' => fake()->name()
            ],
            headers:[
                'authorization' => "Bearer ".$user->createToken('')->plainTextToken
            ]
        );

        $response->assertStatus(403);
    }

    public function test_program_store_is_admin(): void
    {
        $user = User::factory()->create([
            'is_admin' => 1
        ]);

        $fake_name = fake()->name();

        $response = $this->postJson('/api/program',
            [
                'nama' => $fake_name
            ],
            headers:[
                'authorization' => "Bearer ".$user->createToken('')->plainTextToken
            ]
        );

        $response->assertStatus(201);
        $response->assertJson(['nama'=> $fake_name]); // assert the name in the response is the same with $fake_name
    }

    public function test_program_show_unauthorized(): void
    {
        //$user = User::factory()->create();
        $program = program::factory()->create();

        $response = $this->getJson('/api/program/${$program->id}',
        );

        $response->assertStatus(401);
    }

    public function test_program_show_non_admin(): void
    {
        $user = User::factory()->create();
        $program = program::factory()->create();

        $response = $this->getJson('/api/program/'.$program->id,
            [
                'authorization' => "Bearer ".$user->createToken('')->plainTextToken
            ]
        );

        $response->assertStatus(200);
        $response->assertJson([
            'nama' => $program->nama,
            'id' => $program->id
        ]);
    }

    public function test_program_show_is_admin(): void
    {
        $user = User::factory()->create([
            'is_admin' => 1
        ]);

        $program = program::factory()->create();

        $response = $this->getJson('/api/program/'.$program->id,
            [
                'authorization' => "Bearer ".$user->createToken('')->plainTextToken
            ]
        );

        $response->assertStatus(200);
        $response->assertJson([
            'nama' => $program->nama,
            'id' => $program->id
        ]);
    }
    
    public function test_program_update_is_admin(): void
    {
        $user = User::factory()->create([
            'is_admin' => 1
        ]);

        $program = Program::factory()->create();

        $updatedName = 'New Program Name';

        $response = $this->putJson("/api/program/{$program->id}", [
            'nama' => $updatedName,
        ], [
            'authorization' => "Bearer ".$user->createToken('')->plainTextToken
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['nama' => $updatedName]);
    }

    public function test_program_update_not_admin(): void
    {
        $user = User::factory()->create([
            'is_admin' => 0
        ]);

        $program = Program::factory()->create();

        $response = $this->putJson("/api/program/{$program->id}", [
            'nama' => 'Updated Name',
        ], [
            'authorization' => "Bearer ".$user->createToken('')->plainTextToken
        ]);

        $response->assertStatus(403);
    }

    public function test_program_update_unauthorized(): void
    {
        $program = Program::factory()->create();

        $response = $this->putJson("/api/program/{$program->id}", [
            'nama' => 'Updated Name',
        ]);

        $response->assertStatus(401);
    }

    public function test_program_delete_is_admin(): void
    {
        $user = User::factory()->create([
            'is_admin' => 1
        ]);

        $program = Program::factory()->create();

        $response = $this->deleteJson("/api/program/{$program->id}", [], [
            'authorization' => "Bearer ".$user->createToken('')->plainTextToken
        ]);

        $response->assertStatus(204);

    }

    public function test_program_delete_not_admin(): void
    {
        $user = User::factory()->create();

        $program = Program::factory()->create();

        $response = $this->deleteJson("/api/program/{$program->id}", [], [
            'authorization' => "Bearer ".$user->createToken('')->plainTextToken
        ]);

        $response->assertStatus(403);
    }

    public function test_program_delete_unauthorized(): void
    {
        $program = Program::factory()->create();

        $response = $this->deleteJson("/api/program/{$program->id}");

        $response->assertStatus(401);
    }
}
