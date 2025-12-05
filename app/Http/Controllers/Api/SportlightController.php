<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sportlight;

class SportlightController extends Controller
{
    public function sportlights()
    {
        $sportlights = Sportlight::all();

        return response()->json(['success' => true, 'data' => $sportlights], 200);
    }
}
