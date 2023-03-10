<?php

use Laravel\Lumen\Routing\Router;

include_once 'apiRoutes.php';

// todo separar os tipos de rotas em arquivos.
/** @var Router $router */
$router->group(array('prefix' => '/', 'middleware' => 'auth:web'), function () use ($router) {
//todo fazer redirecionar para 'not found' quando rota não existir ou for inválida
    $router->get('dashboard', array('as' => 'dashboard', 'uses' => 'AuthController@privada'));
});
$router->group(array('prefix' => '/'), function () use ($router) {
//todo fazer redirecionar para 'login' quando rota não existir ou for inválida e o user não estiver logado, caso estiver logado, redirecionar para a 'home' do site
//todo ao fazer login, redirecionar para a rota que tentou acessar e caiu no login
    $router->get('', array('as' => 'home', 'uses' => 'AuthController@home'));
    $router->get('login', array('as' => 'login', 'uses' => 'AuthController@loginView'));
    $router->post('logar', array('as' => 'logar', 'uses' => 'AuthController@login'));
    $router->get('logout', array('as' => 'logout', 'uses' => 'AuthController@logout'));
});