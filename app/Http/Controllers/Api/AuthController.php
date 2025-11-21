<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        // Validasi input
        $request->validate([
            'name'     => 'required|string|max:255',
            'user_name' => 'required|string|max:255|unique:users,user_name',
            'email'    => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Buat user baru
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'user_name'    => $request->user_name,
            'password' => Hash::make($request->password),
        ]);

        // Auto login setelah register
        Auth::login($user);

        // Buat token Sanctum
        $token = $user->createToken('web_token')->plainTextToken;

        return response()->json([
            'message' => 'Signup success',
            'user'    => $user,
            'token'   => $token,
        ]);
    }

    public function signin(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required','email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user  = $request->user();
        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'message' => 'Signin success',
            'user'    => $user,
            'token'   => $token,
        ]);
    }

    // Signout API: hapus token yang dipakai pada request ini
    public function signout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Signed out']);
    }
}
