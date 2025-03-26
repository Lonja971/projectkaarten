<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\TeacherMiddleware;

//---AUTH---

require __DIR__.'/auth.php';

//---HOME---

use App\Http\Controllers\HomeController;    
Route::get('/', [HomeController::class, 'index'])->name('home');

//---HELP---

use App\Http\Controllers\HelpController;
Route::get('/help', [HelpController::class, 'index'])->name('help')->middleware(['auth', 'verified']);

//---USERS---

use App\Http\Controllers\UserController;
Route::prefix('admin')->middleware(TeacherMiddleware::class)->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/{user_nr}', [UserController::class, 'show'])->name('users.show');
    Route::get('/{user_nr}/edit', [UserController::class, 'edit'])->name('users.edit');
});

//---PROJECTS---

use App\Http\Controllers\ProjectController;
Route::get('{user_nr}/', [ProjectController::class, 'index'])
    ->name('projects.index')
    ->middleware(['auth', 'verified'])
    ->where([
        'user_nr' => '[0-9]+'
    ]);

Route::get('{user_nr}/{project_by_user_nr?}', [ProjectController::class, 'show'])
    ->name('projects.show')
    ->middleware(['auth', 'verified'])
    ->where([
        'user_nr' => '[0-9]+'
    ]);

//---SPRINTS---

use App\Http\Controllers\SprintController;
Route::get('{user_nr}/{project_by_user_nr}/{sprint_week_nr?}', [SprintController::class, 'show'])
    ->name('sprints.show')
    ->middleware(['auth', 'verified'])
    ->where([
        'user_nr' => '[0-9]+'
    ]);
