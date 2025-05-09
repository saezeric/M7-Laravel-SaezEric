<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Card;
use App\Http\Controllers\Api\CardController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Middleware\IsUserAuth;
use App\Http\Middleware\IsAdmin;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::get('/cards/test-connection', function () {
//     return Card::all();
// });

// PUBLIC ROUTES

Route::get('register', [AuthController::class, 'register']);
Route::get('login', [AuthController::class, 'login']);

Route::get('/cards',          [CardController::class, 'index']);
Route::get('/cards/{id}',     [CardController::class, 'show']);
Route::post('/cards',         [CardController::class, 'store']);
Route::put('/cards/{id}',     [CardController::class, 'update']);
Route::patch('/cards/{id}',   [CardController::class, 'updatePartial']);
Route::delete('/cards/{id}',  [CardController::class, 'destroy']);

// PROTECTED ROUTES

Route::middleware([IsUserAuth::class])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'getUser']);
    // Route::post('cards', [CardController::class, 'put']);
});

// ADMIN ROUTES
Route::middleware([IsAdmin::class])->group(function () {
    Route::get('users', [AuthController::class, 'index']);
    Route::get('/users/{id}', [AuthController::class, 'show']);
    Route::put('/users/{id}', [AuthController::class, 'update']);
    Route::delete('/users/{id}', [AuthController::class, 'destroy']);
    // cards
    // Route::post('cards', [CardController::class, 'put']);
    // Route::put('/cards/{id}', [CardController::class, 'update']);
    // Route::delete('/cards/{id}', [CardController::class, 'destroy']);
});
