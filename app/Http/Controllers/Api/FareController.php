<?php

namespace App\Http\Controllers\Api;
use App\Models\Fare;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class FareController extends Controller
{
   
    public function latest(): JsonResponse
    {
        $fare = Fare::latest()->first();

        return response()->json([
            'base_fare' => $fare->base_fare,
            'per_km_rate' => $fare->per_km_rate,
            'base_distance_km' => $fare->base_distance_km,
            'currency' => $fare->currency,
        ]);
    }
}
