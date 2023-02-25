<?php

use Laravel\Lumen\Routing\Router;

/** @var Router $router */
$router->get('/index', 'testeController@indexTeste');
$router->get('/get/{id}', 'testeController@getTeste');
$router->post('/post', 'testeController@postTeste');
$router->put('/put/{id}', 'testeController@putTeste');
$router->delete('/delete/{id}', 'testeController@deleteTeste');
