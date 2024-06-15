<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CarController;
use App\Http\Controllers\PartController;



Route::get('/cars', [CarController::class, 'index']);
Route::get('/cars/byName/{name}', [CarController::class, 'getByName']);
Route::get('/cars/byRegNum/{registration_number}', [CarController::class, 'getByRegistrationNumber']);
Route::get('/cars/byIsReg/{is_registered}', [CarController::class, 'getByIsRegistered']);
Route::put('/cars/{id}', [CarController::class, 'update']);
Route::delete('/cars/{id}', [CarController::class, 'delete']);
Route::post('/cars', [CarController::class, 'create']);

Route::get('/parts', [PartController::class, 'index']);
Route::get('/parts/byName/{name}', [PartController::class, 'getByName']);
Route::get('/parts/bySerNum/{serialnumber}', [PartController::class, 'getBySerialNumber']);
Route::get('/parts/byCarName/{carName}', [PartController::class, 'getByCarName']);
Route::put('/parts/{id}', [PartController::class, 'update']);
Route::delete('/parts/{id}', [PartController::class, 'delete']);
Route::post('/parts', [PartController::class, 'create']);

