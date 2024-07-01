<?php

namespace Tests\Feature;

use App\Models\Dana;
use App\Models\LaporanBulanan;
use App\Models\Program;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DanaControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $laporan;
    protected $user;
    protected $endpoint;

    public function setUp(): void
    {
        parent::setUp();

        // Create a user for testing
        $this->user = User::factory()->create();
        $this->laporan = LaporanBulanan::factory()->createOne([
            'disusun_oleh' => $this->user->id,
            'program_id' => Program::factory()->createOne()->id
        ]);

        // Define the API endpoint
        $this->endpoint = '/api/dana';
    }

    public function testIndex()
    {
        Dana::factory()->createOne();

        $response = $this->actingAs($this->user)
                         ->getJson($this->endpoint);

        $response->assertStatus(200);
        $response->assertJsonCount(1);
    }

    public function testIndexFiltered()
    {
        Dana::factory()->createOne([
            'is_pengeluaran' => false,
            'id_laporan_bulanan' => $this->laporan->id
        ]);

        $response = $this->actingAs($this->user)
                         ->getJson("{$this->endpoint}?id_laporan_bulanan={$this->laporan->id}");

        $response->assertStatus(200);
        $response->assertJsonCount(1);
    }

    public function testStore()
    {
        $data = [
            'is_pengeluaran' => 1,
            'jumlah' => fake()->numberBetween(50000, 12000000),
            'ras' => fake()->numberBetween(50000, 12000000),
            'kepesertaan' => fake()->numberBetween(50000, 12000000),
            'dpk' => fake()->numberBetween(50000, 12000000),
            'pusat' => fake()->numberBetween(50000, 12000000),
            'wakaf' => fake()->numberBetween(50000, 12000000),
            'id_laporan_bulanan' => $this->laporan->id
        ];

        $response = $this->actingAs($this->user)
                         ->postJson($this->endpoint, $data);

        $response->assertStatus(201);
        $response->assertJsonFragment($data);
    }

    public function testStoreUnauthorized()
    {
        $data = [
            'is_pengeluaran' => 1,
            'jumlah' => fake()->numberBetween(50000, 12000000),
            'ras' => fake()->numberBetween(50000, 12000000),
            'kepesertaan' => fake()->numberBetween(50000, 12000000),
            'dpk' => fake()->numberBetween(50000, 12000000),
            'pusat' => fake()->numberBetween(50000, 12000000),
            'wakaf' => fake()->numberBetween(50000, 12000000),
            'id_laporan_bulanan' => $this->laporan->id
        ];

        $response = $this->actingAs(User::factory()->createOne())
                         ->postJson($this->endpoint, $data);

        $response->assertStatus(403);
    }

    public function testShow()
    {
        $test = Dana::factory()->createOne([
            'id_laporan_bulanan' => LaporanBulanan::factory()->createOne([
                'disusun_oleh' => $this->user->id,
                'program_id' => Program::factory()->createOne()->id
            ])->id
        ]);

        $response = $this->actingAs($this->user)
                         ->getJson("{$this->endpoint}/{$test->id}");

        $response->assertStatus(200);

    }

    public function testUpdate()
    {
        $test = Dana::factory()->createOne([
            'id_laporan_bulanan' => LaporanBulanan::factory()->createOne([
                'disusun_oleh' => $this->user->id,
                'program_id' => Program::factory()->createOne()->id
            ])->id
        ]);

        $data = [
            'jumlah' => 69420,
            // Add more data here
        ];

        $response = $this->actingAs($this->user)
                         ->putJson("{$this->endpoint}/{$test->id}", $data);

        $response->assertStatus(200);
        $response->assertJsonFragment($data);
    }

    public function testUpdateUnatuhorized()
    {
        $test = Dana::factory()->createOne([
            'id_laporan_bulanan' => LaporanBulanan::factory()->createOne([
                'disusun_oleh' => $this->user->id,
                'program_id' => Program::factory()->createOne()->id
            ])->id
        ]);

        $data = [
            'jumlah' => 69420,
            'id_laporan_bulanan' => LaporanBulanan::factory()->create([
                'disusun_oleh' => User::factory()->createOne()->id,
                'program_id' => Program::factory()->createOne()->id
            ])->id
            // Add more data here
        ];

        $response = $this->actingAs($this->user)
                         ->putJson("{$this->endpoint}/{$test->id}", $data);

        $response->assertStatus(403);
    }

    public function testDestroy()
    {
        $test = Dana::factory()->createOne([
            'id_laporan_bulanan' => LaporanBulanan::factory()->createOne([
                'disusun_oleh' => $this->user->id,
                'program_id' => Program::factory()->createOne()->id
            ])->id
        ]);

        $response = $this->actingAs($this->user)
                         ->deleteJson("{$this->endpoint}/{$test->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('danas', ["id" => $test->id]);
    }
}
