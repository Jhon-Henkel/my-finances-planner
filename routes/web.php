<?php

use App\Enums\RouteEnum;
use App\Enums\ViewEnum;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/** @var Route $router */
$router->prefix('/')->group(function ($router){
    $router->get('sobre', function () {return view(ViewEnum::VIEW_ABOUT);})->name(RouteEnum::WEB_ABOUT);
    $router->get('login', [AuthController::class, 'renderLoginView'])->name(RouteEnum::WEB_LOGIN);
    $router->post('make-login', [AuthController::class, 'login'])->name(RouteEnum::WEB_MAKE_LOGIN);
    $router->get('logout', [AuthController::class, 'logout'])->name(RouteEnum::WEB_LOGOUT);
    $router->get('is-user-logged', [AuthController::class, 'isUserLogged'])->name(RouteEnum::WEB_IS_USER_LOGGED);
    $router->middleware('auth:sanctum')->group(function($router) {
        $router->get('{any}', function () {
            return view(ViewEnum::VIEW_BASE);
        })->where('any', '.*');
    });
});