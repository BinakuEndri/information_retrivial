<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ActorController;

Route::get('/movie', [MovieController::class, 'index']);
Route::get('/movie/{id}', [MovieController::class, 'show']);
Route::get('/actor', [ActorController::class, 'index']);
Route::get('/actor/{id}', [ActorController::class, 'show']);