<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserPasswordChangeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_change(): void
    {
        $user = User::factory()->create();
        $data = [
            "old_password" => "password",
            "new_password" => "gogogogogo",
            "new_password_confirmation" => "gogogogogo",
        ];
        
        $response = $this->actingAs($user)->put('/user/password', $data);

        $response->assertNoContent();
    }
}
