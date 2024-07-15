<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_users_can_register(): void
    {
        $user = User::factory()->create(['is_admin' => 1]);
        $response = $this->actingAs($user)->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'profile_picture' => 'https://upload.wikimedia.org/wikipedia/commons/6/6a/PNG_Test.png'
        ], );

        $response->assertCreated();
    }
}
