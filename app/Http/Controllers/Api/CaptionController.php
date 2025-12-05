<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Caption;

class CaptionController extends Controller
{
    public function captionList()
    {
        $caption = Caption::all();

        return response()->json(['success' => true, 'data' => $caption], 200);
    }
}
