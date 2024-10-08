<?php

use App\Http\Controllers\AlokasiDanaController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ItemKegiatanRKAController;
use App\Http\Controllers\JudulKegiatanRKAController;
use App\Http\Controllers\KeyPerformanceIndicatorController;
use App\Http\Controllers\LaporanBulananController;
use App\Http\Controllers\LaporanKPIBulananController;
use App\Http\Controllers\Mobile\SeeLaporanBulananController;
use App\Http\Controllers\PelaksanaanController;
use App\Http\Controllers\PenerimaManfaatController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\BidangController;
use App\Http\Controllers\Mobile\MobileAuthController;
use App\Http\Controllers\ProgramKegiatanKPIController;
use App\Http\Controllers\ProgramKegiatanRKAController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Stevebauman\Location\Facades\Location;

Route::get('/user', [AuthenticatedSessionController::class, 'check'])
->middleware(['auth:sanctum', 'verified']);

Route::get('/myip', function (Request $request ){
    if( $position = Location::get() ) {
        return response(['ip'=> $position, 'message'=> 'success']);
    } else {
        return response(['ip'=> 'null', 'message'=> 'failed'], 500);
    }
}); // <----

//Route::apiResource('/program', App\Http\Controllers\ProgramController::class)
//->middleware(['auth:sanctum', 'verified']);

Route::group(['prefix' => 'custom', 'middleware' => ['auth:sanctum', 'verified']], function(){
    Route::get('/rencanaAnggaran', [ProgramKegiatanRKAController::class, 'rencanaAnggaran']); 
    Route::get('/tahunanRKA', [ProgramKegiatanRKAController::class, 'tahunanRKA']); 
    Route::get('/RKAKPI', [ProgramKegiatanKPIController::class, 'RKAKPI']); 
});

Route::match(['patch', 'put'], '/laporanBulanan/verify/{laporanBulanan}', [LaporanBulananController::class, 'verify'])
->middleware(['auth:sanctum', 'verified']);

Route::apiResources(
    [
        '/bidang' => BidangController::class,
        '/program' => ProgramController::class,
        '/programKegiatanRKA' => ProgramKegiatanRKAController::class,
        '/programKegiatanKPI' => ProgramKegiatanKPIController::class,
        '/judulKegiatanRKA' => JudulKegiatanRKAController::class,
        '/itemKegiatanRKA' => ItemKegiatanRKAController::class,
        '/keyPerformanceIndicator' => KeyPerformanceIndicatorController::class,

        '/laporanBulanan' => LaporanBulananController::class,
        '/pelaksanaan' => PelaksanaanController::class,
        '/laporanKPIBulanan' => LaporanKPIBulananController::class,
        '/penerimaManfaat' => PenerimaManfaatController::class,
        '/alokasiDana' => AlokasiDanaController::class,
    ],
    [
        'middleware' => [
            'auth:sanctum', 
            'verified',
            'ability:web'
        ]
    ]
);


Route::prefix('mobile')->group(function () {
    Route::get('/bidang', [BidangController::class, 'index'])->name('mobile.bidang');
    Route::get('/program', [ProgramController::class, 'index'])->name('mobile.program');
    Route::get('/laporan', SeeLaporanBulananController::class)->name('mobile.laporan');

    Route::post('/login', [MobileAuthController::class, 'login'])
    ->middleware(['throttle:3,1'])
    ->name('mobile.login');
    Route::post('/register', [MobileAuthController::class, 'register'])
    ->middleware(['throttle:3,1'])
    ->name('mobile.register');
});