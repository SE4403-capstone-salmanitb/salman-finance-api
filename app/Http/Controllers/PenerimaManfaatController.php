<?php

namespace App\Http\Controllers;

use App\Models\PenerimaManfaat;
use App\Http\Requests\StorePenerimaManfaatRequest;
use App\Http\Requests\UpdatePenerimaManfaatRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PenerimaManfaatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize("viewAny", PenerimaManfaat::class);

        $query = PenerimaManfaat::query();

        $filters = [
            'kategori',
            'tipe_rutinitas',
            'tipe_penyaluran',
            'rencana',
            'realisasi',
        ];

        foreach ($filters as $filter) {
            if($request->has($filter)){
                $query->where($filter, "like", "%".$request->input($filter)."%");
            }
        }

        if($request->has("id_laporan_bulanan")){
            $query->where("id_laporan_bulanan", $request->input("id_laporan_bulanan"));
        }

        return response()->json($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePenerimaManfaatRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PenerimaManfaat $penerimaManfaat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePenerimaManfaatRequest $request, PenerimaManfaat $penerimaManfaat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PenerimaManfaat $penerimaManfaat)
    {
        //
    }
}
