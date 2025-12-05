<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Workout;

class WorkoutController extends Controller
{
    public function workoutList()
    {
        $Workouts = Workout::all();

        return response()->json(['success' => true, 'data' => $Workouts], 200);
    }
}
