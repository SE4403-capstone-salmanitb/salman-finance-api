<?php

namespace App\Http\Controllers;

use App\Models\program;
use App\Http\Requests\StoreprogramRequest;
use App\Http\Requests\UpdateprogramRequest;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $programs = program::latest()->paginate(5);

        return response()->json($programs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreprogramRequest $request)
    {
        $program = program::create([
            'nama' => $request->nama
        ]);

        return response()->json($program, $status = 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(program $program)
    {
        return response()->json($program);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateprogramRequest $request, program $program)
    {
        $program->update(['nama' => $request->nama]);

        return response()->json($program);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(program $program)
    {
        $program->delete();

        return response()->noContent();
    }
}
