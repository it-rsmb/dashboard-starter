<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController as ApiAuthController;

Route::post('/signup', [ApiAuthController::class, 'signup']);
Route::post('/signin', [ApiAuthController::class, 'signin']); // API signin

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });

    Route::post('/signout', [ApiAuthController::class, 'signout']);
    // tambahkan endpoint API protected lain di sini
});
