<?php

use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;

Route::get('{any}', [WebController::class, 'index'])
    ->where('any', '.*');
