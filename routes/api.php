<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScoreBoardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);

// Encode Plan

Route::post('/encode', [ScoreBoardController::class, 'encode']);
Route::post('/encode_target', [ScoreBoardController::class, 'encode_target']);
Route::post('/encode/update', [ScoreBoardController::class, 'encode_update']);
Route::delete('/encode/delete/{id}', [ScoreBoardController::class, 'encode_delete']);
Route::get('/encode/{id}', [ScoreBoardController::class, 'get_encode']);

// Encode Target
Route::get('/daily_target', [ScoreBoardController::class, 'targets']);
Route::get('/encode/{id}/{date}', [ScoreBoardController::class, 'get_encode_date']);
Route::get('/current', [ScoreBoardController::class, 'current']);
Route::get('/actual_targets', [ScoreBoardController::class, 'actual_targets']);
Route::get('/edit_target/{id}', [ScoreBoardController::class, 'edit_target']);
Route::post('/update_target', [ScoreBoardController::class, 'update_target']);
Route::delete('/target/delete/{id}', [ScoreBoardController::class, 'target_delete']);

// MOnitors
Route::get('/today_combine_line', [ScoreBoardController::class, 'today_combine_line']);
Route::get('/today_line_a', [ScoreBoardController::class, 'today_line_a']);
Route::get('/today_line_b', [ScoreBoardController::class, 'today_line_b']);

// Users
Route::post('/user/create', [UserController::class, 'create']);
Route::post('/user/update', [UserController::class, 'update']);
Route::get('/users', [UserController::class, 'index']);
Route::get('/user/{email}', [UserController::class, 'edit']);
Route::delete('/user/delete/{email}', [UserController::class, 'delete']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/job/{id}', [ScoreBoardController::class, 'get_job']);
});
