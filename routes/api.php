<?php

use App\Enums\RouteEnum;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

/** @var Route $router */
$router->prefix('/')->middleware('auth.api:api')->group(function ($router){
    $router->prefix('wallet')->group(function () use ($router) {
        $router->get('', [WalletController::class, 'index'])->name(RouteEnum::API_WALLET_INDEX);
        $router->get('/{id}', [WalletController::class, 'show'])->name(RouteEnum::API_WALLET_SHOW);
        $router->post('', [WalletController::class, 'insert'])->name(RouteEnum::API_WALLET_INSERT);
        $router->put('/{id}', [WalletController::class, 'update'])->name(RouteEnum::API_WALLET_UPDATE);
        $router->delete('/{id}', [WalletController::class, 'delete'])->name(RouteEnum::API_WALLET_DELETE);
        $router->prefix('/type')->group(function () use ($router) {
            $router->get('/{type}', [WalletController::class, 'showByType'])->name(RouteEnum::API_WALLET_SHOW_TYPE);
        });
    });
    $router->prefix('movement')->group(function () use ($router) {
        $router->get('', [MovementController::class, 'index'])->name(RouteEnum::API_MOVEMENT_INDEX);
        $router->get('/{id}', [MovementController::class, 'show'])->name(RouteEnum::API_MOVEMENT_SHOW);
        $router->post('', [MovementController::class, 'insert'])->name(RouteEnum::API_MOVEMENT_INSERT);
        $router->put('/{id}', [MovementController::class, 'update'])->name(RouteEnum::API_MOVEMENT_UPDATE);
        $router->delete('/{id}', [MovementController::class, 'delete'])->name(RouteEnum::API_MOVEMENT_DELETE);
        $router->prefix('/type')->group(function () use ($router) {
            $router->get('/{type}', [MovementController::class, 'showByType'])->name(RouteEnum::API_MOVEMENT_SHOW_TYPE);
        });
    });
});