<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\PersonalRecordController;
use App\Http\Controllers\MovementController;


Route::get('/users',[ UserController::class, 'getUsers' ])->middleware('api');
Route::get('/movements',[ MovementController::class, 'getMovements' ])->middleware('api');
Route::get('/ranking',[ MovementController::class, 'getMovementRanking' ])->middleware('api');
Route::get('/personal-records',[ PersonalRecordController::class, 'getPersonalRecords' ])->middleware('api');
