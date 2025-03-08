<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'authenticate']);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/me', [AuthController::class, 'me']);
});
