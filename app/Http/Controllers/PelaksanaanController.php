<?php

namespace App\Http\Controllers;

use App\Models\Pelaksanaan;
use App\Http\Requests\StorePelaksanaanRequest;
use App\Http\Requests\UpdatePelaksanaanRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;

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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Pelaksanaan $pelaksanaan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePelaksanaanRequest $request, Pelaksanaan $pelaksanaan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pelaksanaan $pelaksanaan)
    {
        //
    }
}
