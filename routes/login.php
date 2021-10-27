<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->post('/login', ['uses' => 'LoginController@login']);

$router->get('/logout', ['uses' => 'LoginController@logout', 'middleware' => 'auth']);
