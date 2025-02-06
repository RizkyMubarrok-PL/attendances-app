<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessTokenResult;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email|',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (empty($user)) {
            return response()->json([
                'status' => false,
                'msg' => 'User email tidak ditemukan.'
            ], 404);
        }

        $token = $user->createToken('SiHadir')->plainTextToken;

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            return response()->json([
                'status' => true,
                'users' => $user,
                'token' => $token,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'Email atau password tidak cocok.'
            ], 401);
        }
    }
}
