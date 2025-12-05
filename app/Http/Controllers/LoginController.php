<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function adminlogin(Request $request)
    {

        $params = $request->all();

        $messages = [
            'email.required' => 'Please enter User Name',
        ];

        $rules = ['email' => 'required', 'password' => 'required'];
        $validator = validator()->make($params, $rules, $messages);
        if ($validator->fails()) {
            return response()->json(
                ['status' => 'errors', 'message' => $validator->errors()]
            );
        }

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return response()->json(['status' => 'success']);
        }

        return response()->json(
            ['status' => 'error', 'message' => 'Invalid Credentials!']
        );
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
