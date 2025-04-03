<?php

use App\Http\Controllers\HelpController;
use Illuminate\Support\Facades\Route;

//---AUTH---

require __DIR__.'/auth.php';
require __DIR__.'/api.php';

//---HOME---

use App\Http\Controllers\HomeController;    
Route::match(['get', 'post'], '/', [HomeController::class, 'index'])->name('home');

//---HELP---

Route::get('/help', [HelpController::class, 'index'])->name('help')->middleware(['auth', 'verified']);

//---ADMIN---

use App\Http\Controllers\UserController;
Route::prefix('admin')->middleware('auth.teacher')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/{user_identifier}', [UserController::class, 'show'])->name('admin.users.show');
    Route::get('/{user_identifier}/edit', [UserController::class, 'edit'])->name('admin.users.edit');

    Route::any('{any}', function () {
        abort(404);
    })->where('any', '.*');
});

//---PROJECTS---

use App\Http\Controllers\ProjectController;
Route::get('{user_identifier}/', [ProjectController::class, 'index'])
    ->name('users.index')
    ->middleware(['auth', 'verified']);

Route::get('{user_identifier}/{project_by_user_identifier?}', [ProjectController::class, 'show'])
    ->name('projects.show')
    ->middleware(['auth', 'verified']);

//---SPRINTS---

use App\Http\Controllers\SprintController;
Route::get('{user_identifier}/{project_by_user_identifier}/{sprint_week_nr?}', [SprintController::class, 'show'])
    ->name('sprints.show')
    ->middleware(['auth', 'verified']);
