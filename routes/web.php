<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

//---AUTH---

require __DIR__.'/auth.php';

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//---HOME---

use App\Http\Controllers\HomeController;    
Route::get('/', [HomeController::class, 'index'])->name('home');

//---HELP---

use App\Http\Controllers\HelpController;
Route::get('/help', [HelpController::class, 'index'])->name('help')->middleware(['auth', 'verified']);

//---USERS---

use App\Http\Controllers\UserController;
Route::prefix('/users/')->group(function () {             //---For-future:-Only-Docenten
    Route::get('/', [UserController::class, 'index'])->name('users.index')->middleware(['auth', 'verified']);
    Route::get('{user_nr?}', [UserController::class, 'show'])->name('users.show')->middleware(['auth', 'verified']);
    Route::get('{user_nr}', [UserController::class, 'edit'])->name('users.edit')->middleware(['auth', 'verified']);
});

//---PROJECTS---

use App\Http\Controllers\ProjectController;
Route::get('{user_nr}/', [ProjectController::class, 'index'])->name('projects.index')->middleware(['auth', 'verified']);
Route::get('{user_nr}/{project_by_user_nr?}', [ProjectController::class, 'show'])->name('projects.show')->middleware(['auth', 'verified']);

//---SPRINTS---

use App\Http\Controllers\SprintController;
Route::get('{user_nr}/{project_by_user_nr}/{sprint_week_nr?}', [SprintController::class, 'show'])->name('sprints.show')->middleware(['auth', 'verified']);