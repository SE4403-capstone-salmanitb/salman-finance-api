<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stevebauman\Location\Facades\Location;
use Symfony\Component\HttpFoundation\Response;

class geolocationNotification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // in case not login
        if(!($user = $request->user())){
            return $response;
        }

        // Search if the current location is on historu
        $lastLocation = DB::table('geolocation_history')
        ->where('user_id', $user->id)
        ->where('ip', $request->ip())
        ->get();

        // if not then save the location to history and notify user
        if ($lastLocation->isEmpty() && $newLocation = Location::get()){
            DB::table('geolocation_history')
            ->insert(
                array_merge([
                    'user_id'=>$user->id,
                    'created_at'=> now(),
                    'updated_at'=> now()
                ], $newLocation->toArray()
            )); 


        }

        return $response;
    }
}
