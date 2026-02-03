<?php

use App\Http\Controllers\MoviesController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('news.index');
});

Route::resource('news', NewsController::class);
Route::resource('movies', MoviesController::class);
