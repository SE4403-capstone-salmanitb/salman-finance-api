<?php

namespace App\Http\Controllers;

use App\Models\Pelaksanaan;
use App\Http\Requests\StorePelaksanaanRequest;
use App\Http\Requests\UpdatePelaksanaanRequest;
use App\Models\LaporanBulanan;
use App\Models\ProgramKegiatanKPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PelaksanaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize("viewAny", Pelaksanaan::class);
        $query = Pelaksanaan::query();

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

        return response()->json($query->get()->load("programKegiatan"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePelaksanaanRequest $request)
    {
        Gate::authorize("create", Pelaksanaan::class);

        /** @var LaporanBulanan */
        $laporanBulanan = LaporanBulanan::where("id", $request->validated("id_laporan_bulanan"))->first();
        
        $laporanBulanan->checkIfAuthorizedToEdit($request->user());

        
        if ($request->validated("id_program_kegiatan_kpi") !== null){
            /** @var ProgramKegiatanKPI */
            $prokegKPI = ProgramKegiatanKPI::where("id", $request->validated("id_program_kegiatan_kpi"))->first();

            if($laporanBulanan->program->id !== $prokegKPI->program->id ){
                return response()
                ->json([
                    'message' => 'Program tidak cocok',
                    'errors' => [
                        'id_laporan_bulanan' => ["Entitas ini termasuk dalam program yang berbeda"],
                        'id_program_kegiatan_kpi' => ["Entitas ini termasuk dalam program yang berbeda"],
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
            'message' => 'Program tidak cocok',
            'errors' => [
                'id_laporan_bulanan' => ["Entitas ini termasuk dalam program yang berbeda"],
                'id_program_kegiatan_kpi' => ["Entitas ini termasuk dalam program yang berbeda"],
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

            $laporan->checkIfAuthorizedToEdit($request->user());

        }

        $pelaksanaan->updateOrFail(array_filter($request->validated()));
        return response()->json($pelaksanaan);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pelaksanaan $pelaksanaan, Request $request)
    {
        Gate::authorize('delete', $pelaksanaan);

        $pelaksanaan->deleteOrFail();

        return response()->noContent();
    }
}
