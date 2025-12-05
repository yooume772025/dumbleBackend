<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;

class CountryController extends Controller
{
    public function country()
    {
        $caption = Country::all();

        return response()->json(['success' => true, 'data' => $caption], 200);
    }
}
