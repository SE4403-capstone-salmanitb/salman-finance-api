<?php

namespace App\Http\Controllers;

use App\Models\LaporanKPIBulanan;
use App\Http\Requests\StoreLaporanKPIBulananRequest;
use App\Http\Requests\UpdateLaporanKPIBulananRequest;
use App\Models\KeyPerformanceIndicator;
use App\Models\LaporanBulanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class LaporanKPIBulananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize("viewAny", LaporanKPIBulanan::class);
        $query = LaporanKPIBulanan::query();

        $likeFilters = [
            "capaian",
            "deskripsi"
        ];

        $idFilters = [
            "id_kpi",
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

        return response()->json($query->get()->load("KPI.programKegiatan"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLaporanKPIBulananRequest $request)
    {
        Gate::authorize("create", LaporanKPIBulanan::class);

        /** @var LaporanBulanan */
        $laporanBulanan = LaporanBulanan::where("id", $request->validated("id_laporan_bulanan"))->first();
        
        $laporanBulanan->checkIfAuthorizedToEdit($request->user());

        /** @var KeyPerformanceIndicator */
        $sebuahkpi = KeyPerformanceIndicator::where("id", $request->validated("id_kpi"))->first();

        if($laporanBulanan->program->id !== $sebuahkpi->programKegiatan->program->id ){
            throw ValidationException::withMessages([
                'id_laporan_bulanan' => ["This entity belongs to a different program"],
                'id_kpi' => ["This entity belongs to a different program"],
            ]);
        }

        if ($record = LaporanKPIBulanan::where('id_kpi', $request->id_kpi)
            ->where('id_laporan_bulanan', $request->id_laporan_bulanan)
            ->first()) {
            
            // A record for the foreign ID already exists for the given month.
            throw ValidationException::withMessages([
                'id_laporan_bulanan' => ["Unique constrain violation"],
                'id_kpi' => ["Unique constrain violation"],
            ]);
        }
        

        $programKegiatanKPI = LaporanKPIBulanan::create(array_filter($request->validated()));

        return response()->json($programKegiatanKPI, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(LaporanKPIBulanan $laporanKPIBulanan)
    {
        Gate::authorize("view", $laporanKPIBulanan);

        return response()->json($laporanKPIBulanan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLaporanKPIBulananRequest $request, LaporanKPIBulanan $laporanKPIBulanan)
    {
        Gate::authorize("update", $laporanKPIBulanan);

        $failResponse = response()
        ->json([
            'message' => 'Missmatch program',
            'errors' => [
                'id_laporan_bulanan' => ["This entity belongs to a different program"],
                'id_program_kegiatan_kpi' => ["This entity belongs to a different program"],
            ]
        ], 422);

        if ($request->validated("id_kpi") !== null){
            /** @var KeyPerfomanceIncator */
            $kpi = KeyPerformanceIndicator::where(
                "id", $request->validated("id_kpi")
            )->first();

            if($laporanKPIBulanan->laporanBulanan->program->id !== 
                $kpi->programKegiatan->program->id ){
                return $failResponse;
            }
        } else if ($request->validated("id_laporan_bulanan") !== null) {
            /** @var LaporanBulanan */
            $laporan = LaporanBulanan::where(
                "id", $request->validated("id_laporan_bulanan")
            )->first();

            if($laporanKPIBulanan->KPI->programKegiatan->program->id
                !== $laporan->program->id ){
                return $failResponse;
            } 
            $laporan->checkIfAuthorizedToEdit($request->user());
        }

        $laporanKPIBulanan->updateOrFail(array_filter($request->validated()));
        return response()->json($laporanKPIBulanan);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LaporanKPIBulanan $laporanKPIBulanan, Request $request)
    {
        Gate::authorize("delete", $laporanKPIBulanan);

        $laporanKPIBulanan->deleteOrFail();
        
        return response()->noContent();
    }
}
