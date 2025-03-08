<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'authenticate'])->name('login');

// Protected routes
Route::middleware('auth')->group(function () {
    // Auth routes
    Route::get('/me', [AuthController::class, 'me']);
    
    // Add other protected routes here...
});
