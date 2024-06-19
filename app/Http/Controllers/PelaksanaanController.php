<?php

namespace App\Http\Controllers;

use App\Models\Pelaksanaan;
use App\Http\Requests\StorePelaksanaanRequest;
use App\Http\Requests\UpdatePelaksanaanRequest;
use App\Models\LaporanBulanan;
use App\Models\ProgramKegiatanKPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PelaksanaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize("viewAny", Pelaksanaan::class);
        $query = DB::table('pelaksanaans');

        $likeFilters = [
            "penjelasan",
            "waktu",
            "tempat",
            "penyaluran",
        ];

        $idFilters = [
            "id_program_kegiatan_kpi",
            "id_laporan_bulanan"
        ];

        foreach ($idFilters as $key) {
            if ($request->has($key)){
                $query->where($key, '=', $request->input($key));
            }
        }

        foreach ($likeFilters as $key) {
            if ($request->has($key)){
                $query->where($key, 'like', '%'.$request->input($key).'%');
            }
        }

        return response()->json($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePelaksanaanRequest $request)
    {
        /** @var LaporanBulanan */
        $laporanBulanan = LaporanBulanan::where("id", $request->validated("id_laporan_bulanan"))->first();
        
        Gate::authorize('create', $laporanBulanan, Pelaksanaan::class);
        
        if ($request->validated("id_program_kegiatan_kpi") !== null){
            /** @var ProgramKegiatanKPI */
            $prokegKPI = ProgramKegiatanKPI::where("id", $request->validated("id_program_kegiatan_kpi"))->first();

            if($laporanBulanan->program->id !== $prokegKPI->program->id ){
                return response()
                ->json([
                    'message' => 'Missmatch program',
                    'errors' => [
                        'id_laporan_bulanan' => ["This entity belongs to a different program"],
                        'id_program_kegiatan_kpi' => ["This entity belongs to a different program"],
                    ]
                ], 422);
            }
        }

        $programKegiatanKPI = Pelaksanaan::create(array_filter($request->validated()));

        return response()->json($programKegiatanKPI, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pelaksanaan $pelaksanaan)
    {
        Gate::authorize('view', $pelaksanaan);
        return response()->json($pelaksanaan);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePelaksanaanRequest $request, Pelaksanaan $pelaksanaan)
    {
        Gate::authorize("update", $pelaksanaan);

        $failResponse = response()
        ->json([
            'message' => 'Missmatch program',
            'errors' => [
                'id_laporan_bulanan' => ["This entity belongs to a different program"],
                'id_program_kegiatan_kpi' => ["This entity belongs to a different program"],
            ]
        ], 422);

        if ($request->validated("id_program_kegiatan_kpi") !== null){
            /** @var ProgramKegiatanKPI */
            $prokegKPI = ProgramKegiatanKPI::where(
                "id", $request->validated("id_program_kegiatan_kpi")
            )->first();

            if($pelaksanaan->laporanBulanan->program->id !== $prokegKPI->program->id ){
                return $failResponse;
            }
        } else if ($request->validated("id_laporan_bulanan") !== null) {
            /** @var LaporanBulanan */
            $laporan = LaporanBulanan::where(
                "id", $request->validated("id_laporan_bulanan")
            )->first();

            if($pelaksanaan->programKegiatan->program->id !== $laporan->program->id ){
                return $failResponse;
            }
        }

        $pelaksanaan->updateOrFail(array_filter($request->validated()));
        return response()->json($pelaksanaan);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pelaksanaan $pelaksanaan)
    {
        Gate::authorize('delete', $pelaksanaan);

        $pelaksanaan->deleteOrFail();

        return response()->noContent();
    }
}
