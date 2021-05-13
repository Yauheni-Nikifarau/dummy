<?php

use App\Http\Controllers\API\HotelController;
use App\Http\Controllers\API\MessageController;
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

Route::get('/orders', [OrderController::class, 'index']);
Route::get('/orders/{id}', [OrderController::class, 'show']);
Route::get('/trips', [TripController::class, 'index']);
Route::get('/trips/{id}', [TripController::class, 'show']);
Route::get('/hotels', [HotelController::class, 'index']);
Route::get('/hotels/{id}', [HotelController::class, 'show']);
Route::get('/messages', [MessageController::class, 'index']);
Route::get('/messages/{id}', [MessageController::class, 'show']);

