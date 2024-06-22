<?php

use App\Http\Controllers\ItemKegiatanRKAController;
use App\Http\Controllers\JudulKegiatanRKAController;
use App\Http\Controllers\KeyPerformanceIndicatorController;
use App\Http\Controllers\LaporanBulananController;
use App\Http\Controllers\PelaksanaanController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ProgramKegiatanKPIController;
use App\Http\Controllers\ProgramKegiatanRKAController;
use App\Http\Middleware\geolocationNotification; // <----
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Stevebauman\Location\Facades\Location;

Route::middleware(['auth:sanctum', 'verified'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/myip', function (Request $request ){
    if( $position = Location::get() ) {
        return response(['ip'=> $position, 'message'=> 'success']);
    } else {
        return response(['ip'=> 'null', 'message'=> 'failed'], 500);
    }
}); // <----

//Route::apiResource('/program', App\Http\Controllers\ProgramController::class)
//->middleware(['auth:sanctum', 'verified']);

Route::prefix('custom')->group(function(){
    Route::get('/rencanaAnggaran', [ProgramKegiatanRKAController::class, 'rencanaAnggaran']); 
    Route::get('/tahunanRKA', [ProgramKegiatanRKAController::class, 'tahunanRKA']); 
    Route::get('/RKAKPI', [ProgramKegiatanKPIController::class, 'RKAKPI']); 
})->middleware(['auth:sanctum', 'verified']);

Route::patch('/laporanBulanan/verify/{laporanBulanan}', [LaporanBulananController::class, 'verify'])
->middleware(['auth:sanctum', 'verified']);

Route::apiResources(
    [
        '/program' => ProgramController::class,
        '/programKegiatanRKA' => ProgramKegiatanRKAController::class,
        '/programKegiatanKPI' => ProgramKegiatanKPIController::class,
        '/judulKegiatanRKA' => JudulKegiatanRKAController::class,
        '/itemKegiatanRKA' => ItemKegiatanRKAController::class,
        '/keyPerformanceIndicator' => KeyPerformanceIndicatorController::class,

        '/laporanBulanan' => LaporanBulananController::class,
        '/pelaksanaan' => PelaksanaanController::class,
    ],
    [
        'middleware' => ['auth:sanctum', 'verified']
    ]
);