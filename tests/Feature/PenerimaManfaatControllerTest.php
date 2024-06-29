<?php

namespace Tests\Feature;

use App\Models\LaporanBulanan;
use App\Models\PenerimaManfaat;
use App\Models\Program;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class PenerimaManfaatControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_user_can_view_all_penerima_manfaat(): void
    {
        $user = User::factory()->createOne();
        PenerimaManfaat::factory()->count(7)->create();
        $response = $this->actingAs($user)->get('/api/penerimaManfaat');

        $response->assertStatus(200);
        $response->assertJsonCount(7);
    }

    public function test_user_can_view_all_penerima_manfaat_with_filter() {
        $user = User::factory()->createOne();
        $prog = Program::factory()->createOne();
        $lap = LaporanBulanan::factory()->createOne(["program_id" => $prog->id]);
        $data = [
            "kategori" => "Lorem ipsum sir dolor",
            "id_laporan_bulanan" => $lap->id
        ];

        PenerimaManfaat::factory()->count(7)->create();
        PenerimaManfaat::factory()->createOne($data);
        $response = $this->actingAs($user)->get('/api/penerimaManfaat?kategori='.$data["kategori"].
                    "&id_laporan_bulanan=".$lap->id);

        $response->assertStatus(200);
        $response->assertJsonCount(1);
    }

    public function test_user_can_create_new_penerima_manfaat() 
    {
        $user = User::factory()->createOne();
        $prog = Program::factory()->createOne();
        $lap = LaporanBulanan::factory()->createOne([
            "program_id" => $prog->id, 
            "disusun_oleh" => $user->id
        ]);
        $data = [
            "kategori" => "Internal",
            "tipe_rutinitas" => "Rutin",
            "tipe_penyaluran" => "Dakwah-Advokasi",
            "rencana" => 4,
            "realisasi" => 4,
            "id_laporan_bulanan" => $lap->id
        ];

        $response = $this->actingAs($user)->postJson("/api/penerimaManfaat", $data);

        $response->assertCreated();
    }

    public function test_random_user_cannot_create_new_penerima_manfaat() 
    {
        $user = User::factory()->createOne();
        $user2 = User::factory()->createOne();
        $prog = Program::factory()->createOne();
        $lap = LaporanBulanan::factory()->createOne([
            "program_id" => $prog->id, 
            "disusun_oleh" => $user->id
        ]);
        $data = [
            "kategori" => "Internal",
            "tipe_rutinitas" => "Rutin",
            "tipe_penyaluran" => "Dakwah-Advokasi",
            "rencana" => 4,
            "realisasi" => 4,
            "id_laporan_bulanan" => $lap->id
        ];

        $response = $this->actingAs($user2)->postJson("/api/penerimaManfaat", $data);

        //Log::error(json_encode($response->json()));
        $response->assertStatus(403);
    }

    public function test_user_can_see_specific_penerima_manfaat()
    {
        $user = User::factory()->createOne();
        $test = PenerimaManfaat::factory()->createOne();

        $response = $this->actingAs($user)->getJson(
            "/api/penerimaManfaat/".$test->id
        );

        $response->assertOk();
        $response->assertJsonFragment($test->toArray());
    }
}
