<?php

namespace App\Http\Controllers;

use App\Models\Dana;
use App\Http\Requests\StoreDanaRequest;
use App\Http\Requests\UpdateDanaRequest;
use App\Models\LaporanBulanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DanaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Dana::class);

        $q = Dana::query();

        $filters = [
            'id_laporan_bulanan',
            'is_pengeluaran'
        ];

        foreach ($filters as $filter) {
            if ($request->has($filter)){
                $q->where('id_laporan_bulanan', $request->input($filter));
            }
        }

        return response()->json($q->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDanaRequest $request)
    {
        Gate::authorize('create', Dana::class);

        LaporanBulanan::find($request->id_laporan_bulanan)->checkIfAuthorizedToEdit($request->user());

        $dana = Dana::create(array_filter($request->validated()));

        return response()->json($dana, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Dana $dana)
    {
        Gate::authorize('view', $dana);
        
        return response()->json($dana);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDanaRequest $request, Dana $dana)
    {
        Gate::authorize('update', $dana);

        $this->checkAuthorizedToEditNewLaporan($request);

        $dana->updateOrFail(array_filter($request->validated()));
        
        return response()->json($dana);
    }

    private function checkAuthorizedToEditNewLaporan(Request $request) {
        if ($request->has('id_laporan_bulanan')){
            LaporanBulanan::findOrFail($request->id_laporan_bulanan)
                ->checkIfAuthorizedToEdit($request->user());
        }
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dana $dana)
    {
        Gate::authorize("delete", $dana);

        $dana->deleteOrFail();

        return response()->noContent();
    }
}
