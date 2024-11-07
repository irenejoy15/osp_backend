<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScoreBoardController;

Route::get('/job/{id}', [ScoreBoardController::class, 'get_job']);
Route::post('/encode', [ScoreBoardController::class, 'encode']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
