<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserManagementControllerTest extends TestCase
{
    use DatabaseTruncation;
    
    public function test_index(): void
    {
        $user = User::factory()->create([ "is_admin" => 1 ]);
        User::factory()->count(9)->create();
        
        $response = $this->actingAs($user)->get('/user');

        $response->assertStatus(200);
        $response->assertJsonCount(10);
    }

    public function test_toggle(): void
    {
        $user = User::factory()->create([ "is_admin" => 1 ]);
        $user2 = User::factory()->create([ "is_admin" => 0 ]);
        
        $response = $this->actingAs($user)->post("/user/".$user2->id."/toggleAdmin");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            "is_admin" => true
        ]);
    }
}
