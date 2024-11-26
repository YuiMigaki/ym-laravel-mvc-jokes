<?php
/**
 * Assessment Title: Portfolio Part 3
 * Cluster:          Cluster - SaaS: Front-End Dev - ICT50220 (Advanced Programming)
 * Qualification:    ICT50220 Diploma of Information Technology (Back End Web Development)
 * Name:             Yui Migaki
 * Student ID:       20098757
 * Year/Semester:    2024/S2
 *
 * YOUR SUMMARY OF PORTFOLIO ACTIVITY
 * This portfolio is based on a scenario where I am employed as a Junior Web Application Developer at RIoT Systems,
 * a Perth-based company specializing in IoT, Robotics, and Web Application systems. My task is to implement
 * a simple web application using PHP and elements of the MVC (Model-View-Controller) development methodology.
 * The process involves following a predefined set of steps, with opportunities to consult stakeholders or their representatives for guidance.
 * The ultimate goal is to develop a web application that aligns with the company's expertise in IoT, Robotics, and Web
 *
 */

use App\Http\Controllers\JokeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolesAndPermissionsController;
use App\Http\Controllers\StaticController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\StaticController::class, 'home'])
    ->name('home');

//Route::get('welcome', [\App\Http\Controllers\StaticController::class, 'home'])
//    ->name('welcome');


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
Route::post('search',  [\App\Http\Controllers\JokeController::class, 'search'])
    ->name('search');
Route::match(['get', 'post'], 'search', [\App\Http\Controllers\JokeController::class, 'search'])
    ->name('search'); //Make this to handle both GET and POST methods


Route::get('jokes/trash', [JokeController::class, 'trash'])
    ->name('jokes.trash');
Route::get('jokes/{id}/trash/restore', [JokeController::class, 'restore'])
    ->name('jokes.trash-restore');
Route::delete('jokes/{id}/trash/remove', [JokeController::class, 'remove'])
    ->name('jokes.trash-remove');
Route::post('jokes/trash/recover', [JokeController::class, 'recoverAll'])
    ->name('jokes.trash-recover');
Route::delete('jokes/trash/empty', [JokeController::class, 'empty'])
    ->name('jokes.trash-empty');

Route::resource('jokes', JokeController::class)
    ->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy', 'search']);






Route::get('users/trash', [UserController::class, 'trash'])
    ->name('users.trash');
Route::get('users/{id}/trash/restore', [UserController::class, 'restore'])
    ->name('users.trash-restore');
Route::delete('users/{id}/trash/remove', [UserController::class, 'remove'])
    ->name('users.trash-remove');
Route::post('users/trash/recover', [UserController::class, 'recoverAll'])
    ->name('users.trash-recover');
Route::delete('users/trash/empty', [UserController::class, 'empty'])
    ->name('users.trash-empty');

Route::resource('users', UserController::class)
    ->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy', 'search']);




Route::middleware('auth')->group(function () {

    Route::match(['get', 'post'], '/user/search',  [\App\Http\Controllers\UserController::class, 'search'])
        ->name('users.search');//Make this to handle both GET and POST methods
    Route::match(['get', 'post'], '/joke/search', [\App\Http\Controllers\JokeController::class, 'search'])
        ->name('jokes.search');//Make this to handle both GET and POST methods



    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');



    Route::resource('users', UserController::class)
        ->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy']);

    Route::resource('jokes', JokeController::class)
        ->only(['create','store', 'edit', 'update', 'destroy']);



});



// role-assignment screen
Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth', 'verified', 'role:Superuser|Admin|Staff']
], function () {

    Route::get('/permissions', [RolesAndPermissionsController::class, 'index'])
        ->name('admin.permissions');

    Route::post('/assign_role', [RolesAndPermissionsController::class, 'store'])
        ->name('admin.assign-role');

    Route::delete('/revoke_role', [RolesAndPermissionsController::class, 'destroy'])
        ->name('admin.revoke-role');


});



require __DIR__.'/auth.php';
