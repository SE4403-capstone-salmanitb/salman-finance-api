<?php

namespace App\Http\Controllers;

use App\Models\ItemKegiatanRKA;
use App\Http\Requests\StoreItemKegiatanRKARequest;
use App\Http\Requests\UpdateItemKegiatanRKARequest;
use Illuminate\Support\Facades\Gate;

class ItemKegiatanRKAController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', ItemKegiatanRKA::class);

        $data = ItemKegiatanRKA::latest()->get();

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemKegiatanRKARequest $request)
    {
        Gate::authorize('create', ItemKegiatanRKA::class);

        $itemKegiatanRKA = ItemKegiatanRKA::create(array_filter($request->validated()));

        return response()->json($itemKegiatanRKA, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemKegiatanRKA $itemKegiatanRKA)
    {
        Gate::authorize('view', $itemKegiatanRKA);
        return response()->json($itemKegiatanRKA);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemKegiatanRKARequest $request, ItemKegiatanRKA $itemKegiatanRKA)
    {
        Gate::authorize('update', $itemKegiatanRKA);

        $itemKegiatanRKA->update(array_filter($request->validated()));

        return response()->json($itemKegiatanRKA, 200);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemKegiatanRKA $itemKegiatanRKA)
    {
        Gate::authorize('delete', $itemKegiatanRKA);
        
        $itemKegiatanRKA->delete();

        return response()->noContent();
    }
}
