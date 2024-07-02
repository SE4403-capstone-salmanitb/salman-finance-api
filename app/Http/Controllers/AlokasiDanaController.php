<?php

namespace App\Http\Controllers;

use App\Models\AlokasiDana;
use App\Http\Requests\StoreAlokasiDanaRequest;
use App\Http\Requests\UpdateAlokasiDanaRequest;
use App\Models\LaporanBulanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AlokasiDanaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', AlokasiDana::class);

        $query = AlokasiDana::query();

        $this->applyFilter($query, $request, [
            'id_laporan_bulanan',
            'id_item_rka',
        ]);

        return response()->json($query->with('itemKegiatanRKA')->get());
    }

    private function applyFilter($query, Request $request, array $filters){
        foreach ($filters as $filter) {
            # code...
            if ($request->has($filter)){
                $query->where($filter, $request->input($filter));
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAlokasiDanaRequest $request)
    {
        Gate::authorize('create', AlokasiDana::class);

        LaporanBulanan::findOrFail($request->id_laporan_bulanan)
        ->checkIfAuthorizedToEdit($request->user());

        $alokasiDana = AlokasiDana::Create(array_filter($request->validated()));

        return response()->json($alokasiDana, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(AlokasiDana $alokasiDana)
    {
        Gate::authorize('view', $alokasiDana);

        return response()->json($alokasiDana);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAlokasiDanaRequest $request, AlokasiDana $alokasiDana)
    {
        Gate::authorize('update', $alokasiDana);

        $this->checkNewLaporanAuthorization($request->input('id_laporan'), $request->user());

        $alokasiDana->updateOrFail(array_filter($request->validated()));

        return response()->json($alokasiDana);
    }

    private function checkNewLaporanAuthorization($id, $user) {
        if($id !== null) {
            LaporanBulanan::findOrFail($id)->checkIfAuthorizedToEdit($user);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AlokasiDana $alokasiDana)
    {
        Gate::authorize('delete', $alokasiDana);

        $alokasiDana->deleteOrFail();

        return response()->noContent();
    }
}
