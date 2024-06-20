<?php

namespace App\Http\Controllers;

use App\Models\LaporanBulanan;
use App\Http\Requests\StoreLaporanBulananRequest;
use App\Http\Requests\UpdateLaporanBulananRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class LaporanBulananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize("viewAny", LaporanBulanan::class);
        $query = DB::table('laporan_bulanans');

        $filters = ['program_id', 'bulan', 'tahun'];

        if ($request->has('program_id')){
            $query->where('program_id', '=', $request->get('program_id'));
        }

        $verified_filter = $request->input('verified');
        if($verified_filter !== null){
            if($verified_filter == true){
                $query->whereNotNull("diperiksa_oleh");
            } elseif ($verified_filter == false) {
                $query->whereNull("diperiksa_oleh");
            }
        }

        if ($request->has('bulan')) {
            $query->whereMonth('bulan_laporan',"=", $request->input('bulan')); 
        }
    
        if ($request->has('tahun')) {
            $query->whereYear('bulan_laporan', "=", $request->input("tahun")); 
        }

        $query->orderByDesc('bulan_laporan');
        return response()->json($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLaporanBulananRequest $request)
    {
        Gate::authorize("create", LaporanBulanan::class);

        $program = $request->input("program_id");
        $date = Carbon::parse($request->input("bulan_laporan"));
        $record = LaporanBulanan::where('program_id', $program)
                      ->whereYear('bulan_laporan', $date->year)
                      ->whereMonth('bulan_laporan', $date->month)
                      ->first();

        if ($record) {
            // A record for the foreign ID already exists for the given month.
            return response()
            ->json([
                'message' => 'A record for this program ID already exists for this month.',
                'errors' => [
                    'program_id' => ["Unique constrain violation"],
                    'bulan_laporan' => ["Unique constrain violation"],
                ]
            ], 422);
        }

        $data = array_merge([
            "disusun_oleh" => $request->user()->id,
        ],
            array_filter($request->validated())
        );

        $new = LaporanBulanan::create($data);

        return response()->json($new, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(LaporanBulanan $laporanBulanan)
    {
        Gate::authorize("view", $laporanBulanan);

        return response()->json($laporanBulanan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLaporanBulananRequest $request, LaporanBulanan $laporanBulanan)
    {
        Gate::authorize("update", $laporanBulanan);

        $laporanBulanan->updateOrFail(array_filter($request->validated()));
        return response()->json($laporanBulanan);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LaporanBulanan $laporanBulanan)
    {
        Gate::authorize('delete', $laporanBulanan);

        $laporanBulanan->deleteOrFail();

        return response()->noContent();
    }

    public function verify(Request $request, LaporanBulanan $laporanBulanan)
    {
        Gate::authorize('verify', $laporanBulanan);

        $laporanBulanan->updateOrFail([
            "tanggal_pemeriksaan" => now(),
            "diperiksa_oleh" => $request->user()->id
        ]);

        return response()->json($laporanBulanan);
    }
}
