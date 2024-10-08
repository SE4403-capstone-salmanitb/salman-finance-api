<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Http\Requests\StoreProgramRequest;
use App\Http\Requests\UpdateProgramRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        Gate::authorize('viewAny', Program::class);

        $query = Program::query();

        $request->validate([
            'id_bidang' => ['nullable', 'integer', 'exists:bidangs,id']
        ]);

        if ($request->has('id_bidang')){
            $query->where('id_bidang', $request->id_bidang);
        }
        
        return response()->json($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProgramRequest $request)
    {
        Gate::authorize('create', Program::class);

        $Program = Program::create(array_filter($request->validated()));

        return response()->json($Program, $status = 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Program $Program)
    {
        Gate::authorize('view', $Program);

        return response()->json($Program);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProgramRequest $request, Program $Program)
    {
        Gate::authorize('update', $Program);

        $Program->update(array_filter($request->validated()));

        return response()->json($Program);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Program $Program)
    {
        Gate::authorize('delete', $Program);

        $Program->delete();

        return response()->noContent();
    }
}
