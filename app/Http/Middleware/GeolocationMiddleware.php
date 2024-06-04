<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class GeolocationMiddleware
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('IP2LOCATION_API_KEY');
    }

    public function handle(Request $request, Closure $next)
    {
        // Get the IP address from the request
        $ipAddress = $request->ip();

        // Use a geolocation service to obtain the geolocation data
        $geolocationData = $this->getGeolocation($ipAddress);

        // Add the geolocation data to the request
        $request->merge(['geolocation' => $geolocationData]);

        return $next($request);
    }

    protected function getGeolocation($ipAddress)
    {
        try {
            $response = $this->client->get("https://api.ip2location.io/?key={$this->apiKey}&ip={$ipAddress}&format=json");
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            // Handle exceptions
            return [
                'ip' => $ipAddress,
                'country' => 'Unknown',
                'city' => 'Unknown',
            ];
        }
    }
}
