<?php

use App\Enums\RouteEnum;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/** @var Route $router */
$router->prefix('/')->group(function ($router){
    // todo quando logar, redirecionar para a página que tentou acessar, o laravel ja tem middleware pronto para isso https://laravel.com/docs/10.x/authentication#password-confirmation-protecting-routes
    // todo ao acessar uma página que necessita de login, redirecionar para a tela de login com mensagem de sem permissão (já redireciona para a tela de login).
    $router->get('home', [AuthController::class, 'home'])->name('home');
    $router->get('login', [AuthController::class, 'renderLoginView'])->name(RouteEnum::WEB_LOGIN);
    $router->post('make-login', [AuthController::class, 'login'])->name(RouteEnum::WEB_MAKE_LOGIN);
    $router->get('logout', [AuthController::class, 'logout'])->name(RouteEnum::WEB_LOGOUT);
    $router->middleware('auth:sanctum')->group(function($router) {
        $router->get('dashboard', [AuthController::class, 'dashboard'])->name(RouteEnum::WEB_DASHBOARD);
    });
});