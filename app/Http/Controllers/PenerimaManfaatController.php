<?php

namespace App\Http\Controllers;

use App\Models\PenerimaManfaat;
use App\Http\Requests\StorePenerimaManfaatRequest;
use App\Http\Requests\UpdatePenerimaManfaatRequest;
use App\Models\LaporanBulanan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

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
        Gate::authorize("create", PenerimaManfaat::class);

        $this->chechForLaporanAuthor($request->id_laporan_bulanan, $request->user());

        $penerimaManfaat = PenerimaManfaat::create(array_filter($request->validated()));

        return response()->json($penerimaManfaat, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(PenerimaManfaat $penerimaManfaat)
    {
        Gate::authorize('view', $penerimaManfaat);

        return response()->json($penerimaManfaat);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePenerimaManfaatRequest $request, PenerimaManfaat $penerimaManfaat)
    {
        Gate::authorize('update', $penerimaManfaat);

        if ($request->has('id_laporan_bulanan')){
            LaporanBulanan::findOrFail($request->id_laporan_bulanan)
                ->checkIfAuthorizedToEdit($request->user());
        }
        
        $penerimaManfaat->updateOrFail(array_filter($request->validated()));
        
        return response()->json($penerimaManfaat);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PenerimaManfaat $penerimaManfaat)
    {
        Gate::authorize("delete", $penerimaManfaat);

        $penerimaManfaat->deleteOrFail();

        return response()->noContent();
    }

    protected function chechForLaporanAuthor(int $id_laporan_bulanan, User $user)
    {
        if( LaporanBulanan::findOrFail($id_laporan_bulanan)->isDisusunOleh($user) === false ){
            abort(403, "Resource belongs to someone else");
        } else {
            return true;
        }
    }
}
