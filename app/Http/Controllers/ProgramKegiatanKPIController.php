<?php

namespace App\Http\Controllers;

use App\Models\ProgramKegiatanKPI;
use App\Http\Requests\StoreProgramKegiatanKPIRequest;
use App\Http\Requests\UpdateProgramKegiatanKPIRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProgramKegiatanKPIController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', ProgramKegiatanKPI::class);

        $data = ProgramKegiatanKPI::latest()->paginate(5);

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProgramKegiatanKPIRequest $request)
    {
        Gate::authorize('create', ProgramKegiatanKPI::class);
        
        $programKegiatanKPI = ProgramKegiatanKPI::create(array_filter($request->validated()));

        return response()->json($programKegiatanKPI, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProgramKegiatanKPI $programKegiatanKPI)
    {
        Gate::authorize('view', $programKegiatanKPI);
        return response()->json($programKegiatanKPI);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProgramKegiatanKPIRequest $request, ProgramKegiatanKPI $programKegiatanKPI)
    {
        Gate::authorize('update', $programKegiatanKPI);

        $programKegiatanKPI->update(array_filter($request->validated()));

        return response()->json($programKegiatanKPI, 200);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProgramKegiatanKPI $programKegiatanKPI)
    {
        Gate::authorize('delete', $programKegiatanKPI);
        
        $programKegiatanKPI->delete();

        return response()->noContent();
    }

    public function RKAKPI(Request $request){
        $request->validate([
            "id_program" => "integer|nullable|exists:programs,id",
            "year" => "integer|nullable"
        ]);

        $result = ProgramKegiatanKPI::with("kpi");

        if($request->has("id_program")){
            $result = $result->where("id_program", $request->id_program);
        }
        if($request->has("year")){
            $result = $result->where("tahun", "=", $request->year);
        }

        return response()->json($result->get());
    }
}
