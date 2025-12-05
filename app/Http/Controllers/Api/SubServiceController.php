<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SubService;

class SubServiceController extends Controller
{
    public function suberviceList()
    {
        $genders = SubService::all();

        return response()->json(['success' => true, 'data' => $genders], 200);
    }

    public function subservicelist($serviceID)
    {

        $subservice = SubService::where('service_id', $serviceID)->get();

        return response()->json(['success' => true, 'data' => $subservice], 200);
    }
}
