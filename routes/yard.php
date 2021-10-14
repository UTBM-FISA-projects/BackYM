<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('/yards/{id:[1-9]\d*}/tasks', ['uses' => 'YardController@getTasks']);

    $router->put('/yards/{id:[1-9]\d*}', ['uses' => 'YardController@put']);

    $router->post('/yards', ['uses' => 'YardController@post']);

    $router->delete('/yards/{id:[1-9]\d*}', ['uses' => 'YardController@delete']);
});
