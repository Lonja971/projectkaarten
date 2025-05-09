<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\SprintController;
use App\Http\Controllers\Api\IconController;
use App\Http\Controllers\Api\BackgroundController;

//---USERS---

Route::middleware('api_key.teacher', 'throttle:cooldown-api')
    ->get('/users/search', [UserController::class, 'search']);
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
    ->apiResource('/sprints', SprintController::class)
    ->except('index');

Route::middleware('api_key.teacher', 'throttle:cooldown-api')
    ->apiResource('/sprints', SprintController::class)
    ->only('index');

//---ICONS AND BACKGROUNDS---

// These routes don't need authentication as they just provide basic data for the UI
Route::get('/icons', [IconController::class, 'index']);
Route::get('/backgrounds', [BackgroundController::class, 'index']);