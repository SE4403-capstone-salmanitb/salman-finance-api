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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreprogramRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(program $program)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateprogramRequest $request, program $program)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(program $program)
    {
        //
    }
}
