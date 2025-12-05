<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pronounce;

class PronounceController extends Controller
{
    public function pronounceList()
    {
        $Pronounce = Pronounce::all();

        return response()->json(['success' => true, 'data' => $Pronounce], 200);
    }
}
