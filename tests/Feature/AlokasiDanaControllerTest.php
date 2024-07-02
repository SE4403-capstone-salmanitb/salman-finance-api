<?php

namespace Tests\Feature;

use App\Models\AlokasiDana;
use App\Models\ItemKegiatanRKA;
use App\Models\LaporanBulanan;
use App\Models\Program;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AlokasiDanaControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    protected $path = '/api/alokasiDana';

    function testUserCanViewAny() {
        $user = User::factory()->createOne();

        $response = $this->actingAs($user)->getJson($this->path);

        $response->assertOk();
    }

    function testUserCanViewWithFilter() {
        $user = User::factory()->createOne();
        $prog = Program::factory()->createOne();
        $lap = LaporanBulanan::factory()->createOne(["program_id" => $prog->id]);
        $irka = ItemKegiatanRKA::factory()->createOne();
        $test = AlokasiDana::factory()->createOne([
            'id_laporan_bulanan' => $lap->id,
            'id_item_rka' => $irka->id
        ]);

        $response = $this->actingAs($user)->getJson(
            "{$this->path}?id_laporan_bulanan={$test->id_laporan_bulanan}&id_item_rka={$test->id_item_rka}"
        );

        $response->assertOk();
        $response->assertJsonFragment($test->toArray());
    }

    function testUserCanCreateNew() {
        $user = User::factory()->createOne();
        $prog = Program::factory()->createOne();
        $lap = LaporanBulanan::factory()->createOne(["program_id" => $prog->id]);
        $irka = ItemKegiatanRKA::factory()->createOne();

        $data = [
            'id_laporan_bulanan' => $lap->id,
            'id_item_rka' => $irka->id,
            'jumlah_realisasi' => fake()->numberBetween(0, $irka->nilai_satuan * $irka->quantity)
        ];

        $response = $this->actingAs($user)->postJson($this->path, $data);

        $response->assertCreated();
        $response->assertJsonFragment($data);
    }

    function testUserCanEdit() {
        $user = User::factory()->createOne();
        $prog = Program::factory()->createOne();
        $lap = LaporanBulanan::factory()->createOne(["program_id" => $prog->id]);
        $irka = ItemKegiatanRKA::factory()->createOne();

        $test = AlokasiDana::factory()->createOne([
            'id_laporan_bulanan' => $lap->id,
            'id_item_rka' => $irka->id
        ]);

        $data = [
            'jumlah_realisasi' => fake()->numberBetween(0, $irka->nilai_satuan * $irka->quantity)+3200
        ];

        $response = $this->actingAs($user)->putJson("$this->path/$test->id", $data);

        $response->assertOk();
        $response->assertJsonFragment($data);
    }

    function testUserCanDelete() {
        $user = User::factory()->createOne();
        $prog = Program::factory()->createOne();
        $lap = LaporanBulanan::factory()->createOne(["program_id" => $prog->id]);
        $irka = ItemKegiatanRKA::factory()->createOne();

        $test = AlokasiDana::factory()->createOne([
            'id_laporan_bulanan' => $lap->id,
            'id_item_rka' => $irka->id
        ]);

        $response = $this->actingAs($user)->deleteJson("$this->path/$test->id");

        $response->assertCreated();
        $this->assertModelMissing($test);
    }
}
