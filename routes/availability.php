<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->put('/availabilities/', ['uses' => 'AvailabilityController@massUpdate']);
});
