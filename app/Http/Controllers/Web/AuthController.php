<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function showForm(Request $request)
    {
       return view('layouts.authentication');
    }

  public function signin(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required','email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return response()->json(['message' => 'Invalid credentials.'], 401);
        }

        $request->session()->regenerate();
        $user  = $request->user();

        // Buat token Sanctum untuk dipakai ke API
        $token = $user->createToken('web_token')->plainTextToken;

        return response()->json([
            'message' => 'Signin success',
            'user'    => $user,
            'token'   => $token,
            'redirect'=> route('dashboard'),
        ]);
    }


    public function signout(Request $request)
    {

        if ($user = $request->user()) {
            $user->tokens()->delete();
        }

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('signin');
    }


}
