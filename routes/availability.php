<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->put('/availabilities/{id:[1-9]\d*}', ['uses' => 'AvailabilityController@update']);

    $router->put('/availabilities/', ['uses' => 'AvailabilityController@massUpdate']);

    $router->post('/availabilities', ['uses' => 'AvailabilityController@create']);

    $router->delete('/availabilities/{id:[1-9]\d*}', ['uses' => 'AvailabilityController@delete']);
});
