<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use DB;

class JobController extends Controller
{
    public function lookingList()
    {
        $jobs = DB::table('looking_for_options')->get();

        return response()->json(['success' => true, 'data' => $jobs], 200);
    }

    public function exerciseList()
    {
        $exercise = Exercise::all();

        return response()->json(['success' => true, 'data' => $exercise], 200);
    }
}
