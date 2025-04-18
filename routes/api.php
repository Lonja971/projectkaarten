<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\SprintController;

//Route::get('/user', function (Request $request) {
    //    return $request->user();
    //})->middleware('auth:sanctum');

//---USERS---

Route::get('/users/search', [UserController::class, 'search']);

Route::middleware('api_key.teacher', 'throttle:cooldown-api')
    ->apiResource('/users', UserController::class);

//---PROJECTS---

Route::middleware('api_key', 'throttle:cooldown-api')
    ->apiResource('/projects', ProjectController::class)
    ->only('show', 'store', 'update');

Route::middleware('api_key.teacher', 'throttle:cooldown-api')
    ->apiResource('/projects', ProjectController::class)
    ->except('show', 'store', 'update');

//---SPRINTS---

Route::middleware('api_key', 'throttle:cooldown-api')
    ->apiResource('/sprints', SprintController::class);