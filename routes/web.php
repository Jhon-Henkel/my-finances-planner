<?php

use Laravel\Lumen\Routing\Router;
use App\Enums\RouteEnum;

/** @var Router $router */
$router->group(array('prefix' => 'api', 'middleware' => 'auth'), function () use ($router) {
//todo fazer redirecionar para 'method not allowed' quando rota não existir ou for inválida
    $router->group(array('prefix' => 'wallet'), function () use ($router) {
        $router->get('', RouteEnum::getRouteParams(RouteEnum::API_WALLET_INDEX));
        $router->get('/{id}', RouteEnum::getRouteParams(RouteEnum::API_WALLET_SHOW));
        $router->post('', RouteEnum::getRouteParams(RouteEnum::API_WALLET_INSERT));
        $router->put('/{id}', RouteEnum::getRouteParams(RouteEnum::API_WALLET_UPDATE));
        $router->delete('/{id}', RouteEnum::getRouteParams(RouteEnum::API_WALLET_DELETE));
        $router->group(array('prefix' => 'type'), function () use ($router) {
            $router->get('/{type}', RouteEnum::getRouteParams(RouteEnum::API_WALLET_SHOW_TYPE));
        });
    });
    $router->group(array('prefix' => 'movement'), function () use ($router) {
        $router->get('', RouteEnum::getRouteParams(RouteEnum::API_MOVEMENT_INDEX));
        $router->get('/{id}', RouteEnum::getRouteParams(RouteEnum::API_MOVEMENT_SHOW));
        $router->post('', RouteEnum::getRouteParams(RouteEnum::API_MOVEMENT_INSERT));
        $router->put('/{id}', RouteEnum::getRouteParams(RouteEnum::API_MOVEMENT_UPDATE));
        $router->delete('/{id}', RouteEnum::getRouteParams(RouteEnum::API_MOVEMENT_DELETE));
        $router->group(array('prefix' => 'type'), function () use ($router) {
            $router->get('/{type}', RouteEnum::getRouteParams(RouteEnum::API_MOVEMENT_SHOW_TYPE));
        });
    });
});
$router->group(array('prefix' => '/', 'middleware' => 'auth'), function () use ($router) {
//todo fazer redirecionar para 'home' quando rota não existir ou for inválida
    $router->get('dashboard', array('as' => 'dashboard', 'uses' => 'AuthController@privada'));
});
$router->group(array('prefix' => '/'), function () use ($router) {
//todo fazer redirecionar para 'login' quando rota não existir ou for inválida e o user não estiver logado,
// caso estiver logado, redirecionar para a 'home' do site
    $router->get('', array('as' => 'home', 'uses' => 'AuthController@home'));
    $router->get('login', array('as' => 'login', 'uses' => 'AuthController@loginView'));
    $router->post('logar', array('as' => 'logar', 'uses' => 'AuthController@login'));
    $router->get('logout', array('as' => 'logout', 'uses' => 'AuthController@logout'));
});