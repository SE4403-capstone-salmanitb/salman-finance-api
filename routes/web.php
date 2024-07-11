<?php

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('IndexPage', ['laravelVersion' => app()->version(), 'phpVersion' => phpversion()]);
});

Route::get('/login', function(){
    return redirect(config("app.frontend_url"), secure:true);
});

require __DIR__.'/auth.php';
