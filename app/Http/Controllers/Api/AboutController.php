<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\About;

class AboutController extends Controller
{
    public function aboutList()
    {
        $about = About::all();

        return response()->json(
            [
                'success' => true,
                'data' => $about,
            ],
            200
        );
    }
}
