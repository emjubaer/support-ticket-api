<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if(Auth::attempt($request->only('email', 'password'))){
            $user = $request->user();

            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
            ]);
        }
        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }
}
