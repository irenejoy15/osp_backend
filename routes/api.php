<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScoreBoardController;

Route::get('/job/{id}', [ScoreBoardController::class, 'get_job']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
