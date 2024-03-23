<?php

use App\Http\Controllers\FixtureController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::get('/teams', [TeamController::class, 'index']);
Route::get('/fixtures/generate', [FixtureController::class, 'generate']);
Route::get('/fixtures/show/{fixture}', [FixtureController::class, 'show']);
