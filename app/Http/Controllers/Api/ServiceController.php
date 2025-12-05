<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;

class ServiceController extends Controller
{
    public function serviceList()
    {
        $genders = Service::all();

        return response()->json(['success' => true, 'data' => $genders], 200);
    }
}
