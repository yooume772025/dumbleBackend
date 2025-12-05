<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use DB;
use Illuminate\Http\Request;

class ChangePassController extends Controller
{
    public function changePassword()
    {
        return view('change-password');
    }

    public function changePass(Request $request)
    {
        $email = User::where('email', $request->email)->first();

        if ($email != null) {
            $token = Str::random(60);

            DB::table('password_resets')
                ->insert(
                    [
                        'email' => $request->email,
                        'token' => $token,
                        'created_at' => now(),
                    ]
                );

            $resetUrl = url(
                "password/reset/{$token}?
            email=" . urlencode($request->email)
            );

            Mail::to($request->email)->send(new PasswordResetMail($resetUrl));

            return response()->json(
                ['message' => 'Password reset email sent!'],
                200
            );
        } else {
            return response()->json(['message' => 'Email not found!'], 404);
        }
    }
}
