<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

// 'use function Pest\Laravel\get;' can usually be removed if not specifically used outside of Pest test files.
// If it's needed for a specific reason in your routes, ensure Pest is a production dependency, which is uncommon.

Route::get('/', [MovieController::class, 'homepage']);

Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.detail');

// Movie Create Routes
Route::get('/create-movie', [MovieController::class, 'create'])->name('movies.create'); // It's good practice to name all routes
Route::post('/create-movie', [MovieController::class, 'store'])->name('movies.store');

// Auth Routes
Route::get('/login', [AuthController::class, 'LoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'loginAction'])->name('login.action'); // Assuming 'login' in AuthController is loginAction or similar
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Movie Edit and Update Routes
Route::get('/movies/{id}/edit', [MovieController::class, 'edit'])->name('movies.edit');
Route::put('/movies/{id}', [MovieController::class, 'update'])->name('movies.update'); // Added this line for the update action

Route::delete('/movies/{id}', [MovieController::class, 'destroy'])->name('movies.destroy');

Route::post('/movies/{id}/restore', [MovieController::class, 'restore'])->name('movies.restore');