<?php

namespace Tests\Feature;

use App\Models\Bidang;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BidangControllerTest extends TestCase
{
    use DatabaseTruncation;

    /**
     * A basic feature test example.
     */
    public function test_index(): void
    {
        Bidang::factory()->count(4)->create();
        $user = User::factory()->createOne();

        $response = $this->actingAs($user)->get('/api/bidang');

        $response->assertStatus(200);
        $response->assertJsonIsArray();
        $response->assertJsonCount(4);
    }

    public function test_show()
    {
        $bidang = Bidang::factory()->createOne();
        $user = User::factory()->createOne();

        $response = $this->actingAs($user)->get("/api/bidang/{$bidang->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment($bidang->toArray());
    }

    public function test_create()
    {
        $user = User::factory()->createOne([
            'is_admin' => 1
        ]);
        $data = [
            'nama' => 'Bidang sebuah testing'.fake()->randomNumber()
        ];

        $response = $this->actingAs($user)->postJson("/api/bidang", $data);

        $response->assertStatus(201);
        $response->assertJsonFragment($data);
    }

    public function test_create_unauthorized()
    {
        
        $user = User::factory()->createOne([
            'is_admin' => 0
        ]);

        $data = [
            'nama' => 'Bidang sebuah testing'.fake()->randomNumber()
        ];

        $response = $this->actingAs($user)->postJson("/api/bidang", $data);

        $response->assertForbidden();
    }

    public function test_update()
    {
        $bidang = Bidang::factory()->createOne();
        
        $user = User::factory()->createOne([
            'is_admin' => 1
        ]);

        $data = [
            'nama' => 'Bidang sebuah testing'.fake()->randomNumber()
        ];

        $response = $this->actingAs($user)->patchJson("/api/bidang/{$bidang->id}", $data);

        $response->assertStatus(200);
        $response->assertJsonFragment($data);
    }

    public function test_update_unauthorized()
    {
        $bidang = Bidang::factory()->createOne();
        
        $user = User::factory()->createOne([
            'is_admin' => 0
        ]);
        
        $data = [
            'nama' => 'Bidang sebuah testing'.fake()->randomNumber()
        ];

        $response = $this->actingAs($user)->patchJson("/api/bidang/{$bidang->id}", $data);

        $response->assertForbidden();
    }

    public function test_delete()
    {
        $bidang = Bidang::factory()->createOne();
        
        $user = User::factory()->createOne([
            'is_admin' => 1
        ]);

        $response = $this->actingAs($user)->deleteJson("/api/bidang/{$bidang->id}");

        $response->assertStatus(204);
        $this->assertModelMissing($bidang);
    }

    public function test_delete_unauthorized()
    {
        $bidang = Bidang::factory()->createOne();
        
        $user = User::factory()->createOne([
            'is_admin' => 0
        ]);

        $response = $this->actingAs($user)->deleteJson("/api/bidang/{$bidang->id}");

        $response->assertForbidden();
    }    
}
