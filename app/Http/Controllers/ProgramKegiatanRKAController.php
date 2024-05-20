<?php

namespace App\Http\Controllers;

use App\Models\ProgramKegiatanRKA;
use App\Http\Requests\StoreProgramKegiatanRKARequest;
use App\Http\Requests\UpdateProgramKegiatanRKARequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ProgramKegiatanRKAController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', ProgramKegiatanRKA::class);

        $data = ProgramKegiatanRKA::latest()->paginate(5);

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

    /**
     * Get the full table view of Program Kegiatan RKA
     */
    public function full(int $year)
    {
        $result = DB::table('program_kegiatan_r_k_a_s')
        ->join('judul_kegiatan_r_k_a_s', 'program_kegiatan_r_k_a_s.id', '=', 'judul_kegiatan_r_k_a_s.id_program_kegiatan_rka')
        ->join('item_kegiatan_r_k_a_s', 'judul_kegiatan_r_k_a_s.id', '=', 'item_kegiatan_r_k_a_s.id_judul_kegiatan')
        ->select('program_kegiatan_r_k_a_s.nama', 'program_kegiatan_r_k_a_s.deskripsi', 'program_kegiatan_r_k_a_s.output',
            DB::raw('SUM(CASE WHEN item_kegiatan_r_k_a_s.sumber_dana = "Pusat" THEN (item_kegiatan_r_k_a_s.nilai_satuan * item_kegiatan_r_k_a_s.quantity * item_kegiatan_r_k_a_s.frequency) ELSE 0 END) AS Dana_Pusat'),
            DB::raw('SUM(CASE WHEN item_kegiatan_r_k_a_s.sumber_dana = "RAS" THEN (item_kegiatan_r_k_a_s.nilai_satuan * item_kegiatan_r_k_a_s.quantity * item_kegiatan_r_k_a_s.frequency) ELSE 0 END) AS Dana_RAS'),
            DB::raw('SUM(CASE WHEN item_kegiatan_r_k_a_s.sumber_dana = "Kepesertaan" THEN (item_kegiatan_r_k_a_s.nilai_satuan * item_kegiatan_r_k_a_s.quantity * item_kegiatan_r_k_a_s.frequency) ELSE 0 END) AS Dana_Kepesertaan'),
            DB::raw('SUM(CASE WHEN item_kegiatan_r_k_a_s.sumber_dana = "Pihak Ketiga" THEN (item_kegiatan_r_k_a_s.nilai_satuan * item_kegiatan_r_k_a_s.quantity * item_kegiatan_r_k_a_s.frequency) ELSE 0 END) AS Dana_Pihak_Ketiga'),
            DB::raw('SUM(CASE WHEN item_kegiatan_r_k_a_s.sumber_dana = "Wakaf Salman" THEN (item_kegiatan_r_k_a_s.nilai_satuan * item_kegiatan_r_k_a_s.quantity * item_kegiatan_r_k_a_s.frequency) ELSE 0 END) AS Dana_Wakaf_Salman'),
            DB::raw('SUM(item_kegiatan_r_k_a_s.nilai_satuan * item_kegiatan_r_k_a_s.quantity * item_kegiatan_r_k_a_s.frequency) AS Total_Dana')
        )
        ->groupBy('program_kegiatan_r_k_a_s.nama', 'program_kegiatan_r_k_a_s.deskripsi', 'program_kegiatan_r_k_a_s.output')
        ->where("program_kegiatan_r_k_a_s.tahun", "=", $year)
        ->get();

        return response()->json($result);
    }
}
