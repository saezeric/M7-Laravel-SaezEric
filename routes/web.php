<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\FilmController;

Route::get('/', function () {
    return redirect('/films');
});

Route::resource('books', BookController::class);
Route::resource('films', FilmController::class);
