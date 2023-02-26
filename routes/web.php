<?php

use Laravel\Lumen\Routing\Router;
use App\Enums\RouteEnum;

//todo fazer redirecionar para 'method not allowed' quando rota não existir
/** @var Router $router */
$router->group(array('prefix' => 'api', 'middleware' => 'auth'), function () use ($router) {
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
});
