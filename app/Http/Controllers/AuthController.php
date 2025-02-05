<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request) {        
        $credentials = $request->validate([
            'email' => 'required|email|',
            'password' => 'required|string'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); 
            $user = Auth::user();

            switch($user->role) {
                case 'admin':
                    return redirect('/dashboard')->with([
                        'status' => true,
                        'msg' =>  'test'
                    ]);
                case 'guru':
                    return redirect('/guru');
                case 'siswa':
                    return redirect('/siswa');
                default: 
                    return redirect()->back()->with([
                        'status' => false,
                        'message' => 'Role tidak dikenali.'
                    ]);
            }
        }

        return redirect()->back()->with([
            'status' => false,
            'message' => 'Email atau password salah.'
        ]);
    }

    public function logout () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    }
}
