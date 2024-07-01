<?php

namespace App\Http\Controllers;

use App\Models\Dana;
use App\Http\Requests\StoreDanaRequest;
use App\Http\Requests\UpdateDanaRequest;

class DanaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDanaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Dana $dana)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDanaRequest $request, Dana $dana)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dana $dana)
    {
        //
    }
}
