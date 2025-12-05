<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sociallogin;
use DB;

class SettingController extends Controller
{
    public function terms()
    {
        $genders = DB::table('settings')->where('id', 1)->first();

        return response()->json(['success' => true, 'data' => $genders], 200);
    }

    public function privacy()
    {
        $genders = DB::table('settings')->where('id', 2)->first();

        return response()->json(['success' => true, 'data' => $genders], 200);
    }

    public function faqs()
    {
        $genders = DB::table('settings')->where('id', 3)->first();

        return response()->json(['success' => true, 'data' => $genders], 200);
    }

    public function cookies()
    {
        $genders = DB::table('settings')->where('id', 4)->first();

        return response()->json(['success' => true, 'data' => $genders], 200);
    }

    public function contactUs()
    {
        $genders = DB::table('settings')->where('id', 5)->first();

        return response()->json(['success' => true, 'data' => $genders], 200);
    }

    public function socialSetting()
    {
        $socialSettings = DB::table('social_setting')->get();

        return response()->json(['success' => true, 'data' => $socialSettings], 200);
    }

    public function sociallogins()
    {
        $socialSettings = Sociallogin::all();

        return response()->json(['success' => true, 'data' => $socialSettings], 200);
    }

    public function admob()
    {
        $admob = DB::table('social_setting')->first();

        return response()->json(['success' => true, 'data' => $admob], 200);
    }
}
