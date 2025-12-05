<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SubGender;

class SubGenderController extends Controller
{
    public function subGenderList($genderID)
    {

        $genders = SubGender::where('gender_id', $genderID)->get();

        return response()->json(['success' => true, 'data' => $genders], 200);
    }
}
