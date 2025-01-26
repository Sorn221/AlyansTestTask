<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/check-auth', function () {

    return response()->json([
        'authorized' => Auth::check(),
        'user' => Auth::check() ? Auth::user() : null,
    ]);
});
