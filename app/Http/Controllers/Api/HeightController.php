<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Height;

class HeightController extends Controller
{
    public function heightList()
    {
        $genders = Height::all();

        return response()->json(['success' => true, 'data' => $genders], 200);
    }
}
