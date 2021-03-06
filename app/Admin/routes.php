<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');

    $router->resource('users', UsersController::class);

    $router->resource('trips', TripController::class);

    $router->resource('hotels', HotelsController::class);

    $router->resource('orders', OrdersController::class);

    $router->resource('tags', TagsController::class);

    $router->prefix('messages')->group(function (Router $internalRouter) {
        $internalRouter->get('received', 'MessageController@receivedMessages');

        $internalRouter->get('sent', 'MessageController@sentMessages');

        $internalRouter->get('received/create', 'MessageController@writeNewMessage');

        $internalRouter->get('sent/create', 'MessageController@writeNewMessage');

        $internalRouter->get('write/{id}', 'MessageController@writeAnswerMessage');

        $internalRouter->post('sent', 'MessageController@saveMessage');
    });

    $router->get('find/users', 'MessageController@findUsersByEmail');
    $router->get('find/hotels', 'TripController@findHotelsByName');
    $router->get('find/discounts', 'TripController@findDiscountsByValue');


});
