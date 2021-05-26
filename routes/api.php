<?php

use App\Http\Controllers\API\HotelController;
use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\TripController;
use App\Http\Controllers\API\UserController;
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

Route::middleware('auth')->group(function () {
    Route::resource('orders', OrderController::class);
    Route::get('orders/{id}/report', [OrderController::class, 'report']);
});

Route::resource('trips', TripController::class);
Route::resource('hotels', HotelController::class);
Route::resource('messages', MessageController::class, ['except' => ['update']])->middleware('auth');
Route::resource('users', UserController::class);


