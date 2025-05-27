<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CardController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\IsUserAuth;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\GameController;
use App\Http\Controllers\CategoryController;


// RUTAS PÚBLICAS
Route::post('register',                        [AuthController::class, 'register']);
Route::post('login',                           [AuthController::class, 'login']);

// RUTAS PROTEGIDAS (USUARIO AUTENTICADO)
Route::middleware([IsUserAuth::class])->group(function () {
    // Autenticación
    Route::post('logout',                      [AuthController::class, 'logout']);
    Route::get('me',                           [AuthController::class, 'getUser']);

    // Cards (usuario)
    Route::get('/my-cards',                    [CardController::class, 'myCards']);
    Route::get('/public-cards',                [CardController::class, 'publicCards']);
    Route::get('/cards/category/{categoryId}', [CardController::class, 'getByCategory']);
    Route::get('/cards/{id}',                  [CardController::class, 'show']);
    Route::post('/cards',                      [CardController::class, 'store']);
    Route::put('/cards/{id}',                  [CardController::class, 'update']);
    Route::patch('/cards/{id}',                [CardController::class, 'updatePartial']);
    Route::delete('/cards/{id}',               [CardController::class, 'destroy']);

    // Games
    Route::get('/games',                       [GameController::class, 'index']);
    Route::post('/games',                      [GameController::class, 'store']);
    Route::put('/games/{game}/finish',         [GameController::class, 'update']);
    Route::delete('/games/{game}',             [GameController::class, 'destroy']);
    Route::get('/ranking',                     [GameController::class, 'ranking']);

    // Categories
    Route::get('/categories',                  [CategoryController::class, 'index']);
    Route::post('/categories',                 [CategoryController::class, 'store']);
    Route::put('/categories/{category}',       [CategoryController::class, 'update']);
    Route::delete('/categories/{category}',    [CategoryController::class, 'destroy']);
});

// RUTAS ADMIN (SOLO ROLE = 'admin')
Route::middleware([IsAdmin::class])->group(function () {
    // 👥 Gestión de usuarios
    Route::get('/users',                       [AuthController::class, 'index']);
    Route::get('/users/{id}',                  [AuthController::class, 'show']);
    Route::put('/users/{id}',                  [AuthController::class, 'update']);
    Route::delete('/users/{id}',               [AuthController::class, 'destroy']);

    // 🃏 CRUD de tarjetas (admin dashboard)
    Route::get('/cards',                       [CardController::class, 'all']); // Listado completo con usuario y categoría

    // 🎮 Gestión de partidas (admin)
    Route::get('/users/{id}/games',            [GameController::class, 'getGamesByUserId']);
});

