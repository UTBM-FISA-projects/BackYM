<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->put('/tasks/{id:[1-9]\d*}/accept', ['uses' => 'TaskController@accept']);

    $router->put('/tasks/{id:[1-9]\d*}', ['uses' => 'TaskController@update']);

    $router->post('/tasks', ['uses' => 'TaskController@create']);
});
