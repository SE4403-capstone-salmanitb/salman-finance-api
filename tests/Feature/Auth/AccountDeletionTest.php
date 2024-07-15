<?php

namespace Tests\Feature\Auth;

use App\Mail\DeleteMyAccountRequested;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AccountDeletionTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_request_deletion(): void
    {
        Mail::fake();

        $user = User::factory()->createOne();
        $response = $this->actingAs($user)->deleteJson('/user/delete', ['password'=>'password']);

        $response->assertStatus(200);

        Mail::assertSent(DeleteMyAccountRequested::class, function ($mail) use ($user) {
            return $mail->hasTo($user);
        });
    }

    public function test_force_destroy(): void
    {
        $user = User::factory()->createOne(['is_admin' => true]);
        $deletedUser = User::factory()->createOne();

        $response = $this->getJson("/verify-delete/{$deletedUser->id}",[
            'Authorization' => "Bearer {$user->createToken('')->plainTextToken}"
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('users', ['id' => $deletedUser->id]);
    }
}
