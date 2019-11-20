<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index() {
        return view('auth.login');
    }

    public function login(Request $request) {

        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');
        if(Auth::attempt($credentials)) {
            return response()->json([
                "status" => "successful"
            ]);
        }
        return response()->json([
            "status" => "Invalid Username and Password"
        ]);
    }

    public function logout() {
        Auth::logout();
        return redirect('/');
    }
}
