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

        $itemKegiatanRKA = ItemKegiatanRKA::create([
            'uraian' => $request->uraian,
            'nilai_satuan' => $request->nilai_satuan,
            'quantity' => $request->quantity,
            'quantity_unit' => $request->quantity_unit,
            'frequency' => $request->frequency,
            'frequency_unit' => $request->frequency_unit,
            'sumber_dana' => $request->sumber_dana,

            'dana_jan' => $request->dana_jan ?? false,
            'dana_feb' => $request->dana_feb ?? false,
            'dana_mar' => $request->dana_mar ?? false,
            'dana_apr' => $request->dana_apr ?? false,
            'dana_mei' => $request->dana_mei ?? false,
            'dana_jun' => $request->dana_jun ?? false,
            'dana_jul' => $request->dana_jul ?? false,
            'dana_aug' => $request->dana_aug ?? false,
            'dana_sep' => $request->dana_sep ?? false,
            'dana_oct' => $request->dana_oct ?? false,
            'dana_nov' => $request->dana_nov ?? false,
            'dana_dec' => $request->dana_dec ?? false,

            'id_judul_kegiatan' => $request->id_judul_kegiatan,
        ]);

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
