<?php

namespace Tests\Feature;

use App\Models\Bidang;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BidangControllerTest extends TestCase
{
    use DatabaseMigrations;

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
        $user = User::factory()->createOne();
        $data = [
            'nama' => 'Bidang sebuah testing'.fake()->randomNumber()
        ];

        $response = $this->actingAs($user)->postJson("/api/bidang", $data);

        $response->assertStatus(201);
        $response->assertJsonFragment($data);
    }
}
