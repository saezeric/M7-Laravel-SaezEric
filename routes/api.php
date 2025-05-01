<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Card;
use App\Http\Controllers\Api\CardController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/cards/test-connection', function () {
    return Card::all();
});

Route::get('/cards',          [CardController::class, 'index']);
Route::get('/cards/{id}',     [CardController::class, 'show']);
Route::post('/cards',         [CardController::class, 'store']);
Route::put('/cards/{id}',     [CardController::class, 'update']);
Route::patch('/cards/{id}',   [CardController::class, 'updatePartial']);
Route::delete('/cards/{id}',  [CardController::class, 'destroy']);
