<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UserProfileChangeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_change_profile_url(): void
    {
        $user = User::factory()->create([ "is_admin" => 1 ]);
        $data = [
            "name" => "test 0029132".random_int(0,200),
            "profile_picture_url" => "https://i.ibb.co.com/5rTrXpF/logo-pinjol-1.png"
        ];
        
        $response = $this->actingAs($user)->patch('/user', $data);

        $response->assertStatus(200);
    }
}
