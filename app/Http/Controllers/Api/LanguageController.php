<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Language;

class LanguageController extends Controller
{
    public function languageList()
    {
        $languages = Language::all();

        return response()->json(['success' => true, 'data' => $languages], 200);
    }
}
