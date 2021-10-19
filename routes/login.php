<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->post('/login', ['uses' => 'LoginController@login']);
