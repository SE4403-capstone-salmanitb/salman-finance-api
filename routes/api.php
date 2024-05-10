<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'verified'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/program', App\Http\Controllers\ProgramController::class)
->middleware(['auth:sanctum', 'verified']);
