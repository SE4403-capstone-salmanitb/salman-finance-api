<?php

namespace Tests\Feature;

use App\Models\LaporanBulanan;
use App\Models\Program;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LaporanBulananControllerTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_index_no_filter(): void
    {
        $user = User::factory()->create();
        LaporanBulanan::factory()->count(5)->create();

        $response = $this->get('/api/laporanBulanan', [
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(200);
        $response->assertJsonCount(5);
    }

    public function test_index_filter_by_program(): void
    {
        $user = User::factory()->create();
        $programs = Program::factory()->count(2)->create();
        LaporanBulanan::factory()->count(5)->create([
            "program_id" => $programs[0]->id
        ]);
        LaporanBulanan::factory()->count(5)->create([
            "program_id" => $programs[1]->id
        ]);

        $target = $programs[0];

        $response = $this->get('/api/laporanBulanan?program_id='.$target->id, [
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(200);
        $response->assertJsonCount(5);
        $response->assertJson([["program_id" => $target->id]]);
    }

    public function test_index_filter_by_year_and_month(): void
    {
        $user = User::factory()->create();
        LaporanBulanan::factory()->count(5)->create([
            "bulan_laporan" => now()
        ]);
        LaporanBulanan::factory()->count(5)->create([
            "bulan_laporan" => now()->subYear()
        ]);

        $target = now();

        $response = $this->get(
            '/api/laporanBulanan?bulan='.$target->month."&tahun=".$target->year, 
            [
                'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
            ]
        );

        $response->assertStatus(200);
        $response->assertJsonCount(5);
        $response->assertJson([["bulan_laporan" => $target->format("Y-m-d")]]);
    }

    public function test_index_filter_by_verified(): void
    {
        $users = User::factory()->count(2)->create();
        LaporanBulanan::factory()->verified()->create();
        LaporanBulanan::factory()->create();

        $response = $this->get(
            '/api/laporanBulanan?verified=1', 
            [
                'authorization' => 'Bearer '.$users[0]->createToken('test')->plainTextToken
            ]
        );

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $this->assertNotNull($response->json()[0]["diperiksa_oleh"]);
    }

    public function test_index_filter_by_unverified(): void
    {
        $user = User::factory()->create();
        LaporanBulanan::factory()->verified()->count(3)->create();
        LaporanBulanan::factory()->count(4)->create();

        $response = $this->get(
            '/api/laporanBulanan?verified=0', 
            [
                'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
            ]
        );

        $response->assertStatus(200);
        $response->assertJsonCount(4);
        $this->assertNull($response->json()[0]["diperiksa_oleh"]);
    }

    /**
     * Test the creation of a LaporanBulanan.
     *
     * @return void
     */
    public function test_Create_LaporanBulanan()
    {
        // Create a user
        $user = User::factory()->create();
        $program = Program::factory()->create();

        // Define the data for the LaporanBulanan
        $data = [
            'program_id' => $program->id,
            'kode' => '#af620e',
            'bulan_laporan' => '2024-02-01',
        ];

        // Send a POST request to the /laporanBulanan endpoint
        $response = $this->post('/api/laporanBulanan', $data, [
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        // Assert that the response status is 201 (Created)
        $response->assertStatus(201);
    }

    /**
     * Test the creation of a LaporanBulanan.
     *
     * @return void
     */
    public function test_Create_LaporanBulanan_missing_field()
    {
        // Create a user
        $user = User::factory()->create();
        $program = Program::factory()->create();

        // Define the data for the LaporanBulanan
        $data = [
            'program_id' => $program->id,
        ];

        // Send a POST request to the /laporanBulanan endpoint
        $response = $this->post('/api/laporanBulanan', $data, [
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken,
            'accept' => "application/json"
        ]);

        // Assert that the response status is 201 (Created)
        $response->assertStatus(422);
    }

    /**
     * Test the update of a LaporanBulanan.
     *
     * @return void
     */
    public function test_Update_LaporanBulanan()
    {
        // Create a user
        $user = User::factory()->create();
        $program = Program::factory()->create();
        $laporanBulanan = LaporanBulanan::factory()->create();

        // Define the data for the update
        $data = [
            'program_id' => $program->id,
            'kode' => '#af620e',
            'bulan_laporan' => '2024-02-01',
        ];

        // Send a PUT request to the /laporanBulanan/{id} endpoint
        $response = $this->actingAs($user)
                         ->json('PATCH', '/api/laporanBulanan/'.$laporanBulanan->id, $data);

        // Assert that the response status is 200 (OK)
        $response->assertStatus(200);
    }

    /**
     * Test the update of a LaporanBulanan.
     *
     * @return void
     */
    public function test_Verify_LaporanBulanan()
    {
        // Create a user
        $users = User::factory()->count(2)->create();
        $laporanBulanan = LaporanBulanan::factory()->create();

        // Send a PUT request to the /laporanBulanan/{id} endpoint
        $response = $this->actingAs($users[1])
                         ->json('PATCH', '/api/laporanBulanan/verify/'.$laporanBulanan->id);

        // Assert that the response status is 200 (OK)
        $response->assertStatus(200);
        $response->assertJson(["diperiksa_oleh" => $users[1]->id]);
    }

    /**
     * Test the update of a LaporanBulanan.
     *
     * @return void
     */
    public function test_Verify_LaporanBulanan_same_user()
    {
        // Create a user
        $users = User::factory()->create();
        $laporanBulanan = LaporanBulanan::factory()->create([
            "disusun_oleh" => $users->id
        ]);

        // Send a PUT request to the /laporanBulanan/{id} endpoint
        $response = $this->actingAs($users)
                         ->json('PATCH', '/api/laporanBulanan/verify/'.$laporanBulanan->id);

        // Assert that the response status is 200 (OK)
        $response->assertStatus(403);
    }

    /**
     * Test the deletion of a LaporanBulanan.
     *
     * @return void
     */
    public function testDeleteLaporanBulanan()
    {
        // Create a user
        $user = User::factory()->create();

        // Create a LaporanBulanan
        $laporanBulanan = LaporanBulanan::factory()->create();

        // Send a DELETE request to the /laporanBulanan/{id} endpoint
        $response = $this->actingAs($user)->delete('/api/laporanBulanan/'.$laporanBulanan->id);

        // Assert that the response status is 200 (OK)
        $response->assertStatus(204);

        // Assert that the LaporanBulanan was deleted from the database
        $this->assertDatabaseMissing('laporan_bulanan', ['id' => $laporanBulanan->id]);
    }

}
