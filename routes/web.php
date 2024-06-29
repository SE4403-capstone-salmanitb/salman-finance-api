<?php

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $html = "
    <body>
        <h1>Laravel ".app()->version()."</h1>
        <p>This product includes GeoLite2 data created by MaxMind, available from
        <a href=\"https://www.maxmind.com\">https://www.maxmind.com</a> and 
        uses IP2Location.io <a href=\"https://www.ip2location.io\">IP geolocation</a> web service.
        </p>
    </body>
    ";
    return Response($html, 200, ['Content-Type' =>'text/html']);
});

Route::get('/login', function(){
    return redirect(config("app.frontend_url"), secure:true);
});

require __DIR__.'/auth.php';
