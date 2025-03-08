<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Project\ProjectController;
use App\Http\Controllers\Task\TaskController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'authenticate'])->name('login');

// Protected routes
Route::middleware('auth')->group(function () {

    Route::get('/me', [AuthController::class, 'me']);

    Route::apiResource('projects', ProjectController::class);

    Route::delete('tasks/{id}', [TaskController::class, 'destroy']);
});
