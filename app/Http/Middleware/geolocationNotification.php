<?php

namespace App\Http\Middleware;

use App\Mail\newLoginLocation;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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
            ->insert([
                'user_id'=>$user->id,
                'ip'=>$request->ip(),
                'latitude' => $newLocation->latitude,
                'longitude' => $newLocation->longitude,
                'countryName' => $newLocation->countryName,
                'countryCode' => $newLocation->countryCode,
                'regionName' => $newLocation->regionName,
                'regionCode' => $newLocation->regionCode,
                'cityName' => $newLocation->cityName,
                'timezone' => $newLocation->timezone,
                'driver' => $newLocation->driver,
                'created_at'=> now(),
                'updated_at'=> now()
            ]); 
            $local = "(".$newLocation->ip.")";
            if($newLocation->countryName){
                $local = $newLocation->countryName.", ".$local;
            }
            if($newLocation->regionName){
                $local = $newLocation->regionName.", ".$local;
            }
            if($newLocation->cityName){
                $local = $newLocation->cityName.", ".$local;
            }

            Mail::to($user->email)->send(new newLoginLocation($local));
        }

        return $response;
    }
}
