<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserEmailChangeControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_email_change(): void
    {
        $user = User::factory()->create();
        $data = [
            "new_email" => "localtes@example.org",
            "password" => "password"
        ];
        
        $response = $this->actingAs($user)->put('/user/email',$data);

        $response->assertNoContent();
    }
}
