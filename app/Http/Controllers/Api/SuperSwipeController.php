<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SuperSwipe;

class SuperSwipeController extends Controller
{
    public function superswipes()
    {
        $superswipes = SuperSwipe::all();

        return response()->json(['success' => true, 'data' => $superswipes], 200);
    }
}
