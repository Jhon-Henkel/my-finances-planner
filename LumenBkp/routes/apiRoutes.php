<?php

use Laravel\Lumen\Routing\Router;
use App\Enums\RouteEnum;

//todo fazer redirecionar para 'method not allowed' quando rota não existir nesse grupo ou for inválida
/** @var Router $router */
$router->group(array('prefix' => 'api', 'middleware' => 'auth:api'), function () use ($router) {
    $router->group(array('prefix' => 'wallet'), function () use ($router) {
        $router->get('', ['as' => RouteEnum::API_WALLET_INDEX, 'uses' => RouteEnum::API_WALLET_INDEX_METHOD]);
        $router->get('/{id}', ['as' => RouteEnum::API_WALLET_SHOW, 'uses' => RouteEnum::API_WALLET_SHOW_METHOD]);
        $router->post('', ['as' => RouteEnum::API_WALLET_INSERT, 'show' => RouteEnum::API_WALLET_INSERT_METHOD]);
        $router->put('/{id}', ['as' => RouteEnum::API_WALLET_UPDATE, 'uses' => RouteEnum::API_WALLET_UPDATE_METHOD]);
        $router->delete('/{id}', ['as' => RouteEnum::API_WALLET_DELETE, 'uses' => RouteEnum::API_WALLET_DELETE_METHOD]);
        $router->group(array('prefix' => 'type'), function () use ($router) {
            $router->get('/{type}', ['as' => RouteEnum::API_WALLET_SHOW_TYPE, 'uses' => RouteEnum::API_WALLET_SHOW_TYPE_METHOD]);
        });
    });
    $router->group(array('prefix' => 'movement'), function () use ($router) {
        $router->get('', ['as' => RouteEnum::API_MOVEMENT_INDEX, 'uses' => RouteEnum::API_MOVEMENT_INDEX_METHOD]);
        $router->get('/{id}', ['as' => RouteEnum::API_MOVEMENT_SHOW, 'uses' => RouteEnum::API_MOVEMENT_SHOW_METHOD]);
        $router->post('', ['as' => RouteEnum::API_MOVEMENT_INSERT, 'uses' => RouteEnum::API_MOVEMENT_INSERT_METHOD]);
        $router->put('/{id}', ['as' => RouteEnum::API_MOVEMENT_UPDATE, 'uses' => RouteEnum::API_MOVEMENT_UPDATE_METHOD]);
        $router->delete('/{id}', ['as' => RouteEnum::API_MOVEMENT_DELETE, 'uses' => RouteEnum::API_MOVEMENT_DELETE_METHOD]);
        $router->group(array('prefix' => 'type'), function () use ($router) {
            $router->get('/{type}', ['as' => RouteEnum::API_MOVEMENT_SHOW_TYPE, 'uses' => RouteEnum::API_MOVEMENT_SHOW_TYPE_METHOD]);
        });
    });
});