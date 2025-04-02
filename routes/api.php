<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//---USER---

use App\Http\Controllers\Api\UserController;
Route::get('/users/search', [UserController::class, 'search']);
Route::resource('/users', UserController::class);