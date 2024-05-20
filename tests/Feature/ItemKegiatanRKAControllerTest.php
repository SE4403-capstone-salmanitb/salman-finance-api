<?php

namespace Tests\Feature;

use App\Models\ItemKegiatanRKA;
use App\Models\JudulKegiatanRKA;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ItemKegiatanRKAControllerTest extends TestCase
{
    /**
     * index with no user authenticated
     */
    public function test_index_no_user(): void
    {
        $response = $this->getJson('/api/itemKegiatanRKA');

        $response->assertStatus(401);
    }

    /**
     * index with a user authenticated
     */
    public function test_index_with_user(): void
    {
        $user = User::factory()->create();
        $response = $this->getJson('/api/itemKegiatanRKA', [
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(200);
    }

    public function test_create_valid_input()
    {
        $user = User::factory()->create();
        $judul = JudulKegiatanRKA::factory()->create();
        $data = [
            'uraian' => 'Test Program Kegiatan RKA',
            'nilai_satuan' => 1000,
            'quantity' => 1,
            'quantity_unit' => "org",
            'frequency' => 1,
            'frequency_unit' => "bln",
            'sumber_dana' => 'RAS',
            'id_judul_kegiatan' => $judul->id,
        ];

        $response = $this->postJson('/api/itemKegiatanRKA', $data, 
        [
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(201);
        $response->assertjson($data);
    }

    public function test_create_invalid_input()
    {
        $user = User::factory()->create();

        $data = [
            'uraian' => 'Test Program Kegiatan RKA',
            'id_judul_kegiatan' => -999,
        ];

        $response = $this->postJson('/api/itemKegiatanRKA', $data, 
        [
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(422);
    }

    public function test_show_no_user()
    {
        $ItemKegiatanRKA = ItemKegiatanRKA::factory()
        ->create();
        $response = $this->getJson('/api/itemKegiatanRKA/'.$ItemKegiatanRKA->id);

        $response->assertStatus(401);
    }

    public function test_show_with_user()
    {  
        $user = User::factory()->create();
        $data = [
            'id' => 9901+random_int(0, 100), 
            'uraian' => 'Test Program Kegiatan RKA',
            'nilai_satuan' => 1000,
            'quantity' => 1,
            'quantity_unit' => "org",
            'frequency' => 1,
            'frequency_unit' => "bln",
            'sumber_dana' => 'Kepesertaan',
        ];

        ItemKegiatanRKA::factory()->create($data);


        $response = $this->getJson('/api/itemKegiatanRKA/'.$data['id'],
        [
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(200);
        $response->assertjson($data);
    }

    public function test_update_valid_input()
    {
        $user = User::factory()->create();
        $newName = "This is the new name";

        $ItemKegiatanRKA = ItemKegiatanRKA::factory()
        ->create();


        $response = $this->patchJson('/api/itemKegiatanRKA/'.$ItemKegiatanRKA->id,
        [
            'uraian' => $newName,

        ],
        [
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['uraian' => $newName]);
    }

    public function test_show_not_found()
    {  
        $user = User::factory()->create();



        $response = $this->getJson('/api/itemKegiatanRKA/100001',
        [
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(404);
    }

    public function test_update_invalid_input()
    {
        $user = User::factory()->create();

        $ItemKegiatanRKA = ItemKegiatanRKA::factory()
        ->create();

        $response = $this->patchJson('/api/itemKegiatanRKA/'.$ItemKegiatanRKA->id,
        [
            'id_judul_kegiatan' => -999
        ],
        [
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(422);
    }

    public function test_update_not_found()
    {
        $user = User::factory()->create();

        $response = $this->patchJson('/api/itemKegiatanRKA/-99',
        [
            'id_judul_kegiatan' => -999
        ],
        [
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(404);
    }

    function test_delete_normal() 
    {
        $user = User::factory()->create();
        $ItemKegiatanRKA =  ItemKegiatanRKA::factory()->create();


        $response = $this->deleteJson('/api/itemKegiatanRKA/'.$ItemKegiatanRKA->id,
        headers:[
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(204);
    }

    function test_delete_not_found() 
    {
        $user = User::factory()->create();


        $response = $this->deleteJson('/api/itemKegiatanRKA/-99',
        headers:[
            'authorization' => 'Bearer '.$user->createToken('test')->plainTextToken
        ]);

        $response->assertStatus(404);
    }
}
