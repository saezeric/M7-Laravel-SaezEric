<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\IsAuthenticated;
use App\Http\Middleware\IsUserAdmin;
use App\Http\Controllers\PetController;

// RUTAS PÚBLICAS
Route::post('/register',         [AuthController::class, 'register']);
Route::post('/login',            [AuthController::class, 'login']);

// RUTAS PROTEGIDAS
Route::middleware([IsAuthenticated::class])->group(function () {
    Route::post('/logout',       [AuthController::class, 'logout']);
    // Pets
    Route::get('/pets',          [PetController::class, 'myPets']);
    Route::post('/pets',         [PetController::class, 'store']);
    Route::get('/pets/{id}',     [PetController::class, 'show']);
    Route::put('/pets/{id}',     [PetController::class, 'update']);
    Route::patch('/pets/{id}',   [PetController::class, 'updatePartial']);
    Route::delete('/pets/{id}',  [PetController::class, 'destroy']);
});

// RUTAS PRIVADAS
Route::middleware([IsUserAdmin::class])->group(function () {
    Route::get('/users',         [AuthController::class, 'index']);
    Route::get('/users/{id}',    [AuthController::class, 'show']);
    Route::put('/users/{id}',    [AuthController::class, 'update']);
    Route::delete('/users/{id}', [AuthController::class, 'destroy']);
    // Pets
    Route::get('/users/{id}/pets', [PetController::class, 'getPetsByUserId']);
});


