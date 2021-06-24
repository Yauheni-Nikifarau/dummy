<?php

use App\Http\Controllers\API\HotelController;
use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\TripController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\DiscountsController;
use App\Http\Controllers\API\TagsController;
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


Route::resource('orders', OrderController::class)->middleware('auth');
Route::get('orders/{order}/report', [OrderController::class, 'report'])->middleware('auth');
Route::resource('trips', TripController::class);
Route::resource('hotels', HotelController::class);
Route::resource('messages', MessageController::class, ['except' => ['update']])->middleware('auth');
Route::resource('users', UserController::class);
Route::get('tags', [TagsController::class, 'index']);
Route::get('discounts', [DiscountsController::class, 'index']);


