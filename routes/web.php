<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::get('/login', function(){
    return redirect('https://localhost/login', secure:true);
});

require __DIR__.'/auth.php';
