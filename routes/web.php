<?php

use Laravel\Lumen\Routing\Router;

/** @var Router $router */
$router->group(array('prefix' => 'api', 'middleware' => 'auth'), function () use ($router) {
    $router->get('/index', array('as' => 'testIndex', 'uses' => 'testeController@indexTeste'));
    $router->get('/get/{id}', array('as' => 'testGet', 'uses' => 'testeController@getTeste'));
    $router->post('/post', array('as' => 'testPost', 'uses' => 'testeController@postTeste'));
    $router->put('/put/{id}', array('as' => 'testPut', 'uses' => 'testeController@putTeste'));
    $router->delete('/delete/{id}', array('as' => 'testDelete', 'uses' => 'testeController@deleteTeste'));
});
