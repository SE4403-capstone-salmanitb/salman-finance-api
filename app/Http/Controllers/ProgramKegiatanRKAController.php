<?php

namespace App\Http\Controllers;

use App\Models\ProgramKegiatanRKA;
use App\Http\Requests\StoreProgramKegiatanRKARequest;
use App\Http\Requests\UpdateProgramKegiatanRKARequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class ProgramKegiatanRKAController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', ProgramKegiatanRKA::class);

        $data = ProgramKegiatanRKA::latest()->get();

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProgramKegiatanRKARequest $request)
    {
        Gate::authorize('create', ProgramKegiatanRKA::class);
        
        $programKegiatanRKA = ProgramKegiatanRKA::create(array_filter($request->validated()));

        return response()->json($programKegiatanRKA, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProgramKegiatanRKA $programKegiatanRKA)
    {
        Gate::authorize('view', $programKegiatanRKA);
        return response()->json($programKegiatanRKA);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProgramKegiatanRKARequest $request, ProgramKegiatanRKA $programKegiatanRKA)
    {
        Gate::authorize('update', $programKegiatanRKA);

        $programKegiatanRKA->update(array_filter($request->validated()));

        return response()->json($programKegiatanRKA, 200);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProgramKegiatanRKA $programKegiatanRKA)
    {
        Gate::authorize('delete', $programKegiatanRKA);
        
        $programKegiatanRKA->delete();

        return response()->noContent();
    }

    public function rencanaAnggaran(Request $request)
    {
        $request->validate([
            "id_program" => "integer|required|exists:programs,id",
            "tahun" => "integer|required"
        ]);

        $result = ProgramKegiatanRKA::query()
            ->where('id_program', $request->id_program)
            ->where('tahun', $request->tahun)
            ->get();

        foreach ($result as $rka){
            $rka->withAppends([
                'DanaFromRAS', 
                'DanaFromPusat', 
                'DanaFromRAS', 
                'DanaFromKepesertaan', 
                'DanaFromPihakKetiga', 
                'DanaFromWakafSalman', 
                'TotalDana'
            ]);
        }

        return response()->json($result->makeHidden('Judul')->all());
    }

    public function tahunanRKA(Request $request){

        $request->validate([
            "id_program" => "integer|nullable|exists:programs,id",
            "year" => "integer|nullable"
        ]);

        $result = ProgramKegiatanRKA::with("judul.item");

        if($request->has("id_program")){
            $result = $result->where("program_kegiatan_r_k_a_s.id_program", $request->id_program);
        }
        if($request->has("year")){
            $result = $result->where("program_kegiatan_r_k_a_s.tahun", "=", $request->year);
        }

        return response()->json($result->get());
    }
}
