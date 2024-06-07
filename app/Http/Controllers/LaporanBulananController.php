<?php

namespace App\Http\Controllers;

use App\Models\LaporanBulanan;
use App\Http\Requests\StoreLaporanBulananRequest;
use App\Http\Requests\UpdateLaporanBulananRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanBulananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DB::table('laporan_bulanans');

        $filters = ['program_id', 'bulan', 'tahun'];

        if ($request->has('program_id')){
            $query->where('program_id', '=', $request->get('program_id'));
        }

        if ($request->input('verified', false)) {
            $query->whereNotNull("diperiksa_oleh"); 
        } elseif ($request->input('verified') === false){
            $query->whereNull("diperiksa_oleh"); 
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(LaporanBulanan $laporanBulanan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLaporanBulananRequest $request, LaporanBulanan $laporanBulanan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LaporanBulanan $laporanBulanan)
    {
        //
    }
}
