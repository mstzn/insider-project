<?php

use App\Http\Controllers\FixtureController;
use App\Http\Controllers\SimulationController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::get('/teams', [TeamController::class, 'index']);
Route::get('/fixtures/generate', [FixtureController::class, 'generate']);
Route::get('/fixtures/show/{fixture}', [FixtureController::class, 'show']);
Route::get('/fixtures/show', [FixtureController::class, 'showCurrent']);
Route::get('/simulation', [SimulationController::class, 'index']);
Route::get('/simulation/play-all-weeks', [SimulationController::class, 'playAllWeeks']);
Route::get('/simulation/play-next-week', [SimulationController::class, 'playNextWeek']);
Route::get('/simulation/reset-data', [SimulationController::class, 'resetData']);
