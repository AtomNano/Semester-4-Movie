<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

use function Pest\Laravel\get;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [MovieController::class, 'homepage']);

Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.detail');

Route::get('/create-movie', [MovieController::class, 'create']);

Route::post('/create-movie', [MovieController::class, 'store'])->name('movies.store');

Route::get('/login',[AuthController::class,'LoginForm'] ) -> name('login');

Route::post('/login',[AuthController::class,'login']);

Route::post('/logout',[AuthController::class,'logout']);