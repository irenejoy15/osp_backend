<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScoreBoardController;

Route::get('/job/{id}', [ScoreBoardController::class, 'get_job']);
Route::post('/encode', [ScoreBoardController::class, 'encode']);
Route::post('/encode_target', [ScoreBoardController::class, 'encode_target']);
Route::post('/encode/update', [ScoreBoardController::class, 'encode_update']);
Route::delete('/encode/delete/{id}', [ScoreBoardController::class, 'encode_delete']);
Route::get('/encode/{id}', [ScoreBoardController::class, 'get_encode']);
Route::get('/daily_target', [ScoreBoardController::class, 'targets']);
Route::get('/encode/{id}/{date}', [ScoreBoardController::class, 'get_encode_date']);
Route::get('/current', [ScoreBoardController::class, 'current']);
Route::get('/actual_targets', [ScoreBoardController::class, 'actual_targets']);
Route::get('/edit_target/{id}', [ScoreBoardController::class, 'edit_target']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
