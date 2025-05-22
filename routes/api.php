<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\IsUserAuth;
use App\Http\Middleware\IsUserAdmin;

// RUTAS PÚBLICAS
Route::post('/register',    [AuthController::class, 'register']);
Route::post('/login',       [AuthController::class, 'login']);


Route::middleware([IsUserAuth::class])->group(function () {
    Route::post('/logout',  [AuthController::class, 'logout']);
});


