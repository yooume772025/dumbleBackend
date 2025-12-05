<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function locationList()
    {
        $Location = Location::all();

        return response()->json(['success' => true, 'data' => $Location], 200);
    }

    public function hometowns()
    {
        $hometowns = DB::table('hometowns')
            ->select('id', 'city_name', 'state', 'country', 'latitude', 'longitude')
            ->orderBy('city_name', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $hometowns,
            'message' => 'Hometowns list retrieved successfully'
        ], 200);
    }

    public function years()
    {
        $years = DB::table('years')
            ->select('id', 'year')
            ->orderBy('year', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $years,
            'message' => 'Years list retrieved successfully'
        ], 200);
    }
}
