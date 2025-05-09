<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\SprintController;

//---USERS---

Route::middleware('api_key.teacher', 'throttle:cooldown-api')
    ->get('/users/search', [UserController::class, 'search']);
Route::middleware('api_key.teacher', 'throttle:cooldown-api')
    ->post('/store-users/excel', [UserController::class, 'storeWithExcel']);
Route::middleware('api_key.teacher', 'throttle:cooldown-api')
    ->apiResource('/users', UserController::class);

//---PROJECTS---

Route::middleware('api_key', 'throttle:cooldown-api')
    ->apiResource('/projects', ProjectController::class)
    ->only('show', 'store', 'update', 'destroy');
Route::middleware('api_key', 'throttle:cooldown-api')
    ->get('/projects-by-user', [ProjectController::class, 'byUser']);

Route::middleware('api_key.teacher', 'throttle:cooldown-api')
    ->apiResource('/projects', ProjectController::class)
    ->except('show', 'store', 'update', 'destroy');

//---SPRINTS---

Route::middleware('api_key', 'throttle:cooldown-api')
    ->apiResource('/sprints', SprintController::class)
    ->except('index');
Route::middleware('api_key', 'throttle:cooldown-api')
    ->get('/sprints-by-project', [SprintController::class, 'byProject']);

Route::middleware('api_key.teacher', 'throttle:cooldown-api')
    ->apiResource('/sprints', SprintController::class)
    ->only('index');