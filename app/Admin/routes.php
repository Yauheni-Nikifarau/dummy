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

    //$router->resource('messages', MessageController::class);

    $router->get('messages/received', 'MessageController@received');

    $router->get('messages/sent', 'MessageController@sent');

    $router->get('message/write/{id}', 'MessageController@writeMessage')->name('writeMessage');

});
