<?php

use App\Http\Controllers\JokeController;
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

Route::get('/joke', [\App\Http\Controllers\JokeController::class, 'index'])
    ->name('joke');
Route::get('/user', [\App\Http\Controllers\UserController::class, 'index'])
    ->name('user');


Route::get('index', [\App\Http\Controllers\UserController::class, 'index'])
    ->name('index');
Route::get('create', [\App\Http\Controllers\UserController::class, 'create'])
    ->name('create');
Route::get('show', [\App\Http\Controllers\UserController::class, 'show'])
    ->name('show');
Route::get('edit', [\App\Http\Controllers\UserController::class, 'edit'])
    ->name('edit');
Route::get('update', [\App\Http\Controllers\UserController::class, 'update'])
    ->name('update');
Route::get('destroy', [\App\Http\Controllers\UserController::class, 'destroy'])
    ->name('destroy');

Route::get('search',  [\App\Http\Controllers\UserController::class, 'search'])
    ->name('search');



Route::get('index', [\App\Http\Controllers\JokeController::class, 'index'])
    ->name('index');
Route::get('create', [\App\Http\Controllers\JokeController::class, 'create'])
    ->name('create');
Route::get('show', [\App\Http\Controllers\JokeController::class, 'show'])
    ->name('show');
Route::get('edit', [\App\Http\Controllers\JokeController::class, 'edit'])
    ->name('edit');
Route::get('update', [\App\Http\Controllers\JokeController::class, 'update'])
    ->name('update');
Route::get('destroy', [\App\Http\Controllers\JokeController::class, 'destroy'])
    ->name('destroy');

Route::get('search', [\App\Http\Controllers\JokeController::class, 'search'])
    ->name('search');




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::resource('users', UserController::class)
    ->middleware(['auth', 'verified'])
    ->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy']);

Route::resource('jokes', JokeController::class)
    ->middleware(['auth', 'verified'])
    ->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy']);




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});


require __DIR__.'/auth.php';
