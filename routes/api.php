<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Card;
use App\Http\Controllers\Api\CardController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\IsUserAuth;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\GameController;
use App\Http\Controllers\CategoryController;





// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::get('/cards/test-connection', function () {
//     return Card::all();
// });

// PUBLIC ROUTES
Route::post('register',  [AuthController::class, 'register']);
Route::post('login',     [AuthController::class, 'login']);

// PROTECTED ROUTES
Route::middleware([IsUserAuth::class])->group(function () {
    Route::post('logout',         [AuthController::class, 'logout']);
    Route::get('me',              [AuthController::class, 'getUser']);
    // CARDS
    Route::get('/cards',          [CardController::class, 'index']);
    Route::get('/cards/{id}',     [CardController::class, 'show']);
    Route::post('cards',          [CardController::class, 'store']);
    // GAMES
    Route::get('/games', [GameController::class, 'index']);
    Route::post('/games', [GameController::class, 'store']);
    Route::put('/games/{game}/finish', [GameController::class, 'update']);
    Route::delete('/games/{game}', [GameController::class, 'destroy']);
    Route::get('/ranking', [GameController::class, 'ranking']);
    // CATEGORIES
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/cards/category/{categoryId}', [CardController::class, 'getByCategory']); // CARDS Y CATEGORIES
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);
});

// ADMIN ROUTES
Route::middleware([IsAdmin::class])->group(function () {
    Route::get('users',           [AuthController::class, 'index']);
    Route::get('/users/{id}',     [AuthController::class, 'show']);
    Route::put('/users/{id}',     [AuthController::class, 'update']);
    Route::delete('/users/{id}',  [AuthController::class, 'destroy']);
    // CARDS
    Route::post('cards',          [CardController::class, 'store']);
    Route::put('/cards/{id}',     [CardController::class, 'update']);
    Route::patch('/cards/{id}',   [CardController::class, 'updatePartial']);
    Route::delete('/cards/{id}',  [CardController::class, 'destroy']);
});

Route::middleware(['auth:api'])->group(function () {
    Route::get('/games', [GameController::class, 'index']);
    Route::post('/games', [GameController::class, 'store']);
    Route::put('/games/{game}/finish', [GameController::class, 'update']);
    Route::delete('/games/{game}', [GameController::class, 'destroy']);
    Route::get('/ranking', [GameController::class, 'ranking']);
    Route::get('/games/user/{id}', [GameController::class, 'getGamesByUserId']);
});

