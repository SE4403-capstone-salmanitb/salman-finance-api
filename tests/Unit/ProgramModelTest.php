<?php

namespace Tests\Unit;

use App\Models\program;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProgramModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     */
    public function test_program_can_be_created(): void
    {
        $this->freezeSecond(function (Carbon $time){
            $programData = [
                'id' => 1,
                'nama' => 'Test Program',
                'created_at' => $time,
                'updated_at' => $time
            ];

            $retrievedProgram = program::factory()->create($programData);

            $this->assertDatabaseHas('programs', $programData);
            $this->assertEquals($programData['id'], $retrievedProgram->id);
            $this->assertEquals($programData['nama'], $retrievedProgram->nama);
            $this->assertEquals($programData['created_at'], $retrievedProgram->created_at);
            $this->assertEquals($programData['updated_at'], $retrievedProgram->updated_at);
        });
    }

    public function test_program_can_be_updated_and_accessed(): void
    {
        $programData = [
            'id' => 1,
            'nama' => 'Test Program',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $newName = "Our newest name";

        $retrievedProgram = program::factory()->create($programData);
        $retrievedProgram->update(['nama' => $newName]);
        $retrievedProgram = program::find(1);


        $this->assertNotEquals($programData['nama'], $retrievedProgram->nama);
        $this->assertEquals($newName, $retrievedProgram->nama);
    }

    public function test_program_can_be_deleted(): void
    {
        $programData = [
            'id' => 1,
            'nama' => 'Test Program',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $retrievedProgram = program::factory()->create($programData);
        $retrievedProgram->delete();


        $this->assertDatabaseMissing('programs', $programData);
    }


}
