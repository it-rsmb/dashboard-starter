<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function showForm(Request $request)
    {
       return view('layouts.authentication');
    }

    public function signin(Request $request)
    {
        // Validate the incoming request data.
        // The 'login' field will accept either an email or a username.
        $request->validate([
            'email'    => ['required', 'string'], // Changed 'email' rule to 'string' to allow usernames
            'password' => ['required', 'string'],
        ]);

        $loginField = $request->input('email');
        $password = $request->input('password');
        $remember = $request->boolean('remember');

        $credentials = [];
        // Determine if the input is an email or a username
        if (filter_var($loginField, FILTER_VALIDATE_EMAIL)) {
            // Input looks like an email
            $credentials = ['email' => $loginField, 'password' => $password];
        } else {
            // Input is assumed to be a username
            $credentials = ['user_name' => $loginField, 'password' => $password];
        }

        // Attempt to authenticate the user with the determined credentials
        if (!Auth::attempt($credentials, $remember)) {
            return response()->json(['message' => 'Invalid credentials.'], 401);
        }

        // If authentication is successful, regenerate the session and get the authenticated user.
        $request->session()->regenerate();
        $user  = $request->user();

        // Get the intended URL from the session, or default to 'dashboard'
        // This allows flexible redirection after login, e.g., to a specific detail page
        $redirectUrl = session()->pull('url.intended', route('dashboard'));

        // Create a Sanctum token for API usage
        $token = $user->createToken('web_token')->plainTextToken;

        return response()->json([
            'message' => 'Signin success',
            'user'    => $user,
            'token'   => $token,
            'redirect'=> $redirectUrl, // Use the determined redirect URL
        ]);
    }

// public function store(Request $request)
// {
//     $request->validate([
//         'name'     => 'required|string|max:255',
//         'email'    => 'required|string|email|unique:users,email',
//         'password' => 'required|string|min:6|confirmed',
//     ]);

//     $user = User::create([
//         'name'     => $request->name,
//         'email'    => $request->email,
//         'password' => Hash::make($request->password),
//     ]);

//     Auth::login($user);

//     $token = $user->createToken('web_token')->plainTextToken;

//     // return response()->json($token);

//     // Simpan di cookie
//   $cookie = cookie(
//         'auth_token',    // name
//         $token,          // value
//         60 * 24 * 30,    // minutes
//         '/',             // path
//         null,            // domain
//         false,           // secure
//         false,           // httpOnly
//         true             // raw - disable encryption
//     );

//     return redirect()->route('dashboard')->withCookie($cookie);
// }



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
