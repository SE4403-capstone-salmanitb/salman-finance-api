<?php

namespace App\Http\Controllers;

use App\Models\JudulKegiatanRKA;
use App\Http\Requests\StoreJudulKegiatanRKARequest;
use App\Http\Requests\UpdateJudulKegiatanRKARequest;
use Illuminate\Support\Facades\Gate;

class JudulKegiatanRKAController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', JudulKegiatanRKA::class);

        $data = JudulKegiatanRKA::latest()->paginate(5);

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJudulKegiatanRKARequest $request)
    {
        Gate::authorize('create', JudulKegiatanRKA::class);
        
        $judulKegiatanRKA = JudulKegiatanRKA::create(array_filter($request->validated()));

        return response()->json($judulKegiatanRKA, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(JudulKegiatanRKA $judulKegiatanRKA)
    {
        info($judulKegiatanRKA);

        Gate::authorize('view', $judulKegiatanRKA);
        return response()->json($judulKegiatanRKA);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJudulKegiatanRKARequest $request, JudulKegiatanRKA $judulKegiatanRKA)
    {
        Gate::authorize('update', $judulKegiatanRKA);

        $judulKegiatanRKA->update(array_filter($request->validated()));

        return response()->json($judulKegiatanRKA, 200);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JudulKegiatanRKA $judulKegiatanRKA)
    {
        Gate::authorize('delete', $judulKegiatanRKA);
        
        $judulKegiatanRKA->delete();

        return response()->noContent();
    }
}
