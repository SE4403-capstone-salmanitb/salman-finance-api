<?php

namespace Tests\Feature\Mobile;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class MobileAuthControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_register(): void
    {
        Mail::fake();

        $body = [
            'name' => 'lorem and ipsum',
            'email' => fake()->email(),
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->post('/mobile/register', $body);

        $response->assertStatus(201);
    }

    public function test_login() {
        $data = [
            'email' =>fake()->email(),
            'is_mobile_user' => true
        ];
        $user = User::factory()->createOne($data);

        $response = $this->post('/mobile/login', [
            'email' => $data['email'],
            'password' => 'password'
        ]);
        
        $response->assertOk();
    }
}
