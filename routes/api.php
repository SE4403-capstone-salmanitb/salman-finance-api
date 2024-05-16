<?php

use App\Http\Controllers\JudulKegiatanRKAController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ProgramKegiatanRKAController;
use App\Models\JudulKegiatanRKA;
use App\Models\ProgramKegiatanRKA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'verified'])->get('/user', function (Request $request) {
    return $request->user();
});

//Route::apiResource('/program', App\Http\Controllers\ProgramController::class)
//->middleware(['auth:sanctum', 'verified']);

Route::apiResources(
    [
        '/program' => ProgramController::class,
        '/programKegiatanRKA' => ProgramKegiatanRKAController::class,
        '/judulKegiatanRKA' => JudulKegiatanRKAController::class
    ],
    [
        'middleware' => ['auth:sanctum', 'verified']
    ]
);