<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Education;

class EducationController extends Controller
{
    public function educationList()
    {
        $educations = Education::all();

        return response()->json(['success' => true, 'data' => $educations], 200);
    }
}
