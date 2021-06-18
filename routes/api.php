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

Route::middleware('auth')->prefix('orders')->group(function () {
    Route::resource('/', OrderController::class);
    Route::get('/{id}/report', [OrderController::class, 'report']);
});

Route::resource('trips', TripController::class);
Route::resource('hotels', HotelController::class);
Route::resource('messages', MessageController::class, ['except' => ['update']])->middleware('auth');
Route::resource('users', UserController::class);
Route::get('tags', [TagsController::class, 'index']);
Route::get('discounts', [DiscountsController::class, 'index']);


