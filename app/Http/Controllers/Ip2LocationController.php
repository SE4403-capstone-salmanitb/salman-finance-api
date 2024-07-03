<?php

namespace App\Http\Controllers;

use App\Services\Ip2LocationService;
use Illuminate\Http\Request;

class Ip2LocationController extends Controller
{
    protected $ip2LocationService;

    public function __construct(Ip2LocationService $ip2LocationService)
    {
        $this->ip2LocationService = $ip2LocationService;
    }

    public function show(Request $request)
    {
        $ip = $request->input('ip');
        $details = $this->ip2LocationService->getIpDetails($ip);

        return response()->json($details);
    }
}
