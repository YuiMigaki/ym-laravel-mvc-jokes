<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\StaticController::class, 'home'])
    ->name('static.home');

Route::get('welcome', [\App\Http\Controllers\StaticController::class, 'home'])
    ->name('welcome');

// TODO: Add Routes for about and contact
Route::get('/about', [\App\Http\Controllers\StaticController::class, 'about'])
    ->name('about');
Route::get('/contact', [\App\Http\Controllers\StaticController::class, 'contact'])
    ->name('contact');

Route::get('joke', [\App\Http\Controllers\JokeController::class, 'joke'])
    ->name('joke');
Route::get('category', [\App\Http\Controllers\CategoryController::class, 'category'])
    ->name('category');


Route::get('index', [\App\Http\Controllers\UserController::class, 'index'])
    ->name('index');
Route::get('create', [\App\Http\Controllers\UserController::class, 'create'])
    ->name('create');
Route::get('show', [\App\Http\Controllers\UserController::class, 'show'])
    ->name('show');
Route::get('show', [\App\Http\Controllers\UserController::class, 'show'])
    ->name('show');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::resource('users', UserController::class)
    ->only(['index', 'show', 'create', 'store', 'edit','update','destroy']);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';
