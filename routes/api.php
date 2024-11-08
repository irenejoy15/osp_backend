<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScoreBoardController;

Route::get('/job/{id}', [ScoreBoardController::class, 'get_job']);
Route::post('/encode', [ScoreBoardController::class, 'encode']);
Route::post('/encode/update', [ScoreBoardController::class, 'encode_update']);
Route::post('/encode/delete/{id}', [ScoreBoardController::class, 'encode_delete']);
Route::get('/encode/{id}', [ScoreBoardController::class, 'get_encode']);
Route::get('/daily_target', [ScoreBoardController::class, 'targets']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
