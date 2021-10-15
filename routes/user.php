<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('/users/{id:[1-9]\d*}', ['uses' => 'UserController@show']);

    $router->get('/users/{id:[1-9]\d*}/availabilities', ['uses' => 'UserController@getAvailabilities']);

    $router->get('/users/notifications', ['uses' => 'UserController@getNotifications']);

    $router->get('/users/{id:[1-9]\d*}/yards', ['uses' => 'UserController@getYards']);

    $router->put('/users', ['uses' => 'UserController@update']);
});
