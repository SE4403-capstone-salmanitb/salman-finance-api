<?php

namespace App\Http\Controllers;

use App\Models\ProgramKegiatanRKA;
use App\Http\Requests\StoreProgramKegiatanRKARequest;
use App\Http\Requests\UpdateProgramKegiatanRKARequest;
use Illuminate\Support\Facades\Gate;

class ProgramKegiatanRKAController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', ProgramKegiatanRKA::class);

        $data = ProgramKegiatanRKA::latest()->paginate(5);

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProgramKegiatanRKARequest $request)
    {
        Gate::authorize('create', ProgramKegiatanRKA::class);
        
        $programKegiatanRKA = ProgramKegiatanRKA::create(array_filter($request->validated()));

        return response()->json($programKegiatanRKA, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProgramKegiatanRKA $programKegiatanRKA)
    {
        Gate::authorize('view', $programKegiatanRKA);
        return response()->json($programKegiatanRKA);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProgramKegiatanRKARequest $request, ProgramKegiatanRKA $programKegiatanRKA)
    {
        Gate::authorize('update', $programKegiatanRKA);

        $programKegiatanRKA->update(array_filter($request->validated()));

        return response()->json($programKegiatanRKA, 200);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProgramKegiatanRKA $programKegiatanRKA)
    {
        Gate::authorize('delete', $programKegiatanRKA);
        
        $programKegiatanRKA->delete();

        return response()->noContent();
    }
}
