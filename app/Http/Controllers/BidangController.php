<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Http\Requests\StoreBidangRequest;
use App\Http\Requests\UpdateBidangRequest;
use Illuminate\Support\Facades\Gate;

class BidangController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Bidang::class);

        return response()->json(Bidang::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBidangRequest $request)
    {
        Gate::authorize('create', Bidang::class);

        $bidang = Bidang::create(array_filter($request->validated()));

        return response()->json($bidang, $status = 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Bidang $bidang)
    {
        Gate::authorize('view', $bidang);

        return response()->json($bidang);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBidangRequest $request, Bidang $bidang)
    {
        Gate::authorize('update', $bidang);

        $bidang->update(array_filter($request->validated()));

        return response()->json($bidang);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bidang $bidang)
    {
        Gate::authorize('delete', $bidang);
        
        $bidang->deleteOrFail();

        return response()->noContent();
    }
}
