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
        $response = $this->actingAs($user)->get("/api/penerimaManfaat?id_laporan_bulanan={$lap->id}");

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
            "rencana" =>(string) 4,
            "realisasi" =>(string) 4,
            "id_laporan_bulanan" =>(string) $lap->id
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
            "rencana" =>(string) 4,
            "realisasi" =>(string) 4,
            "id_laporan_bulanan" =>(string) $lap->id
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

    public function test_user_can_update_penerima_manfaat()
    {
        $user = User::factory()->createOne();
        $prog = Program::factory()->createOne();
        $lap = LaporanBulanan::factory()->createOne([
            "program_id" => $prog->id, 
            "disusun_oleh" => $user->id
        ]);
        $pm = PenerimaManfaat::factory()->createOne([
            "id_laporan_bulanan" => $lap->id
        ]);

        $data = [
            "kategori" => "Internal",
            "tipe_rutinitas" => "Rutin",
            "tipe_penyaluran" => "Dakwah-Advokasi",
            "rencana" =>(string) 4,
            "realisasi" =>(string) 4,
        ];

        $response = $this->actingAs($user)->patchJson("/api/penerimaManfaat/".$pm->id, $data);

        $response->assertOk();
        $response->assertJsonFragment($data);
    }

    public function test_random_user_cannot_update_penerima_manfaat()
    {
        $user = User::factory()->createOne();
        $user2 = User::factory()->createOne();
        $prog = Program::factory()->createOne();
        $lap = LaporanBulanan::factory()->createOne([
            "program_id" => $prog->id, 
            "disusun_oleh" => $user->id
        ]);
        $pm = PenerimaManfaat::factory()->createOne([
            "id_laporan_bulanan" => $lap->id
        ]);

        $data = [
            "kategori" => "Internal",
            "tipe_rutinitas" => "Rutin",
            "tipe_penyaluran" => "Dakwah-Advokasi",
            "rencana" =>(string) 4,
            "realisasi" =>(string) 4,
        ];

        $response = $this->actingAs($user2)->patchJson("/api/penerimaManfaat/".$pm->id, $data);

        $response->assertStatus(403);
    }

    public function test_user_cannot_update_id_laporan_bulanan_to_something_they_dont_own()
    {
        $user = User::factory()->createOne();
        $user2 = User::factory()->createOne();
        $prog = Program::factory()->createOne();
        $lap = LaporanBulanan::factory()->createOne([
            "bulan_laporan" => now()->addMonth(),
            "program_id" => $prog->id, 
            "disusun_oleh" => $user->id
        ]);
        $lap2 = LaporanBulanan::factory()->createOne([
            "program_id" => $prog->id, 
            "disusun_oleh" => $user2->id
        ]);
        $pm = PenerimaManfaat::factory()->createOne([
            "id_laporan_bulanan" => $lap->id
        ]);

        $data = [
            "id_laporan_bulanan" => $lap2->id,
            "kategori" => "Internal",
            "tipe_rutinitas" => "Rutin",
            "tipe_penyaluran" => "Dakwah-Advokasi",
            "rencana" =>(string) 4,
            "realisasi" =>(string) 4,
        ];

        $response = $this->actingAs($user2)->patchJson("/api/penerimaManfaat/".$pm->id, $data);

        $response->assertStatus(403);
    }

    public function test_user_bisa_delete() {
        $user = User::factory()->createOne();
        $prog = Program::factory()->createOne();
        $lap = LaporanBulanan::factory()->createOne([
            "program_id" => $prog->id, 
            "disusun_oleh" => $user->id
        ]);
        $pm = PenerimaManfaat::factory()->createOne([
            "id_laporan_bulanan" => $lap->id
        ]);

        $response = $this->actingAs($user)->deleteJson("/api/penerimaManfaat/".$pm->id);

        $response->assertNoContent();
        $this->assertDatabaseMissing("penerima_manfaats", $pm->toArray());
    }

    public function test_random_user_cannot_delete() {
        $user = User::factory()->createOne();
        $user2 = User::factory()->createOne();
        $prog = Program::factory()->createOne();
        $lap = LaporanBulanan::factory()->createOne([
            "program_id" => $prog->id, 
            "disusun_oleh" => $user->id
        ]);
        $pm = PenerimaManfaat::factory()->createOne([
            "id_laporan_bulanan" => $lap->id
        ]);

        $response = $this->actingAs($user2)->deleteJson("/api/penerimaManfaat/".$pm->id);

        $response->assertStatus(403);
    }
}
