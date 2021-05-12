<?php

use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\TripController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/order', [OrderController::class, 'index']);
Route::get('/trip', [TripController::class, 'index']);
Route::get('/trip/{id}', [TripController::class, 'show']);


