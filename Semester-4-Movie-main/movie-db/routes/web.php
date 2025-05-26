<?php

use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [MovieController::class, 'homepage']);
Route::get('/detail-movie/{id}/{slug}', [MovieController::class, 'detailMovie']);

Route::get('/create-movie', [MovieController::class, 'create'])->name('movies.create');
Route::post('/create-movie', [MovieController::class, 'store'])->name('movies.store');