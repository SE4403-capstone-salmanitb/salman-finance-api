<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\LaporanBulanan;
use App\Models\Program;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class SeeLaporanBulananController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            "id_program" => "integer|required|exists:programs,id",
            "year" => "integer|required",
            'month' => 'integer|required'
        ]);

        /** @var LaporanBulanan */
        $laporanBulanan = LaporanBulanan::where('program_id', $request->id_program)
        ->whereMonth('bulan_laporan', $request->month)
        ->whereYear('bulan_laporan',$request->year)
        ->firstOrFail(); 

        Gate::authorize('view', $laporanBulanan);

        $laporanBulanan->load([
            'program',
            'diperiksaOleh',
            'disusunOleh',
            'pelaksanaans.programKegiatan',
            'KPIBulanans.kpi.programKegiatan',
            'PenerimaManfaats',
            'AlokasiDanas.ItemKegiatanRKA'
        ]);

        return response($laporanBulanan);
    }
}
