<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GeolocationController extends Controller
{
    public function locate(Request $request)
    {
        $ip = $request->input('ip');
        $apiKey = config('services.ip2location.api_key');
        $url = "https://api.ip2location.io/?key={$apiKey}&ip={$ip}";

        $response = Http::get($url);

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['message' => 'Unable to locate IP'], 500);
    }
}
