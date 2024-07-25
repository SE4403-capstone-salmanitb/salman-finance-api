<?php

namespace App\Http\Controllers;

use App\Models\AlokasiDana;
use App\Http\Requests\StoreAlokasiDanaRequest;
use App\Http\Requests\UpdateAlokasiDanaRequest;
use App\Models\LaporanBulanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

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

        $this->UniqueValueCheck($request->id_item_rka, $request->id_laporan_bulanan);

        $alokasiDana = AlokasiDana::Create(array_filter($request->validated()));

        return response()->json($alokasiDana, 201);
    }

    protected function UniqueValueCheck(int $item, int $laporan){
        $record = AlokasiDana::where('id_item_rka', $item)
        ->where('id_laporan_bulanan', $laporan)
        ->first();

        if ($record) {
            // A record for the foreign ID already exists for the given month.
            throw ValidationException::withMessages([
                'id_laporan_bulanan' => ["Unique constrain violation"],
                'id_item_rka' => ["Unique constrain violation"],
            ]);
        }
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
