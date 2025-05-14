<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Card;
use App\Http\Controllers\Api\CardController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\IsUserAuth;
use App\Http\Middleware\IsAdmin;


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
    Route::get('/cards',          [CardController::class, 'index']);
    Route::get('/cards/{id}',     [CardController::class, 'show']);
    Route::post('cards',          [CardController::class, 'store']);
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
