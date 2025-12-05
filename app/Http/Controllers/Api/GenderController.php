<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gender;

class GenderController extends Controller
{
    public function genderList()
    {
        $genders = Gender::all();

        return response()->json(['success' => true, 'data' => $genders], 200);
    }
}
