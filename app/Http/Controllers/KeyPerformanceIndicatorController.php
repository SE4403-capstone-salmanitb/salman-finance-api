<?php

namespace App\Http\Controllers;

use App\Models\KeyPerformanceIndicator;
use App\Http\Requests\StoreKeyPerformanceIndicatorRequest;
use App\Http\Requests\UpdateKeyPerformanceIndicatorRequest;
use Illuminate\Support\Facades\Gate;

class KeyPerformanceIndicatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', KeyPerformanceIndicator::class);

        $data = KeyPerformanceIndicator::latest();

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKeyPerformanceIndicatorRequest $request)
    {
        Gate::authorize('create', KeyPerformanceIndicator::class);

        $keyPerformanceIndicator = KeyPerformanceIndicator::create(array_filter($request->validated()));

        return response()->json($keyPerformanceIndicator, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(KeyPerformanceIndicator $keyPerformanceIndicator)
    {
        Gate::authorize('view', $keyPerformanceIndicator);
        return response()->json($keyPerformanceIndicator);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKeyPerformanceIndicatorRequest $request, KeyPerformanceIndicator $keyPerformanceIndicator)
    {
        Gate::authorize('update', $keyPerformanceIndicator);

        $keyPerformanceIndicator->update(array_filter($request->validated()));

        return response()->json($keyPerformanceIndicator, 200);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KeyPerformanceIndicator $keyPerformanceIndicator)
    {
        Gate::authorize('delete', $keyPerformanceIndicator);
        
        $keyPerformanceIndicator->delete();

        return response()->noContent();
    }
}
