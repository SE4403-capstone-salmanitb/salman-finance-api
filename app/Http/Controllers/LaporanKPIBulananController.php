<?php

namespace App\Http\Controllers;

use App\Models\LaporanKPIBulanan;
use App\Http\Requests\StoreLaporanKPIBulananRequest;
use App\Http\Requests\UpdateLaporanKPIBulananRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;

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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(LaporanKPIBulanan $laporanKPIBulanan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLaporanKPIBulananRequest $request, LaporanKPIBulanan $laporanKPIBulanan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LaporanKPIBulanan $laporanKPIBulanan)
    {
        //
    }
}
