<?php

use App\Http\Controllers\ItemKegiatanRKAController;
use App\Http\Controllers\JudulKegiatanRKAController;
use App\Http\Controllers\KeyPerformanceIndicatorController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ProgramKegiatanKPIController;
use App\Http\Controllers\ProgramKegiatanRKAController;
use App\Http\Controllers\GeolocationController;
use App\Http\Middleware\EnsureTokenIsValid;
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

Route::get('/programKegiatanRKA/full/{year}', [ProgramKegiatanRKAController::class, 'full']) 
->middleware(['auth:sanctum', 'verified']);

Route::apiResources(
    [
        '/program' => ProgramController::class,
        '/programKegiatanRKA' => ProgramKegiatanRKAController::class,
        '/programKegiatanKPI' => ProgramKegiatanKPIController::class,
        '/judulKegiatanRKA' => JudulKegiatanRKAController::class,
        '/itemKegiatanRKA' => ItemKegiatanRKAController::class,
        '/keyPerformanceIndicator' => KeyPerformanceIndicatorController::class,
    ],
    [
        'middleware' => ['auth:sanctum', 'verified']
    ]
);

Route::middleware('auth.api')->group(function () {
    Route::get('/geolocate', [GeolocationController::class, 'locate']);
});

Route::middleware(EnsureTokenIsValid::class)->group(function () {
    Route::get('/geolocate', [GeolocationController::class, 'locate']);
});

Route::middleware('auth.api')->group(function () {
    Route::post('/keystore', [KeystoreController::class, 'store']);
    Route::get('/keystore/{key_name}', [KeystoreController::class, 'retrieve']);
});

Route::get('/security/alert', [SecurityController::class, 'showAlert'])->name('security.alert');
Route::post('/security/deny', [SecurityController::class, 'denyAccess'])->name('security.deny');
Route::post('/security/change-password', [SecurityController::class, 'changePassword'])->name('security.change-password');