<?php

use App\Http\Controllers\Api\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

//---USERS---

use App\Http\Controllers\Api\UserController;

Route::get('/users/search', [UserController::class, 'search']);

Route::middleware('api_key')
    ->apiResource('/users', UserController::class)
    ->only(['show']);

Route::middleware('api_key.teacher')
    ->apiResource('/users', UserController::class)
    ->except(['show']);

//---PROJECTS---

Route::middleware('api_key')->apiResource('/projects', ProjectController::class);