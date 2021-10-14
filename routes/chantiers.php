<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('/chantiers/{id:[1-9]\d*}/missions', ['uses' => 'ChantierController@getMissions']);

    $router->put('/chantiers/{id:[1-9]\d*}', ['uses' => 'ChantierController@put']);

    $router->post('/chantiers', ['uses' => 'ChantierController@post']);

    $router->delete('/chantiers/{id:[1-9]\d*}', ['uses' => 'ChantierController@delete']);
});
