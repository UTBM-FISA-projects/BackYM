<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->put('/notifications/{id:[1-9]\d*}/read', ['uses' => 'NotificationController@setRead']);
});
