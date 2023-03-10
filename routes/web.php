<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
/** @var Route $router */
$router->prefix('/')->group(function ($router){
    //todo quando logar, redirecionar para a página que tentou acessar, o laravel ja tem middleware pronto para isso https://laravel.com/docs/10.x/authentication#password-confirmation-protecting-routes
    //todo ao acessar uma página que necessita de login, redirecionar para a tela de login com mensagem de sem permissão
    $router->get('home', [\App\Http\Controllers\AuthController::class, 'home'])->name('home');
    $router->get('login', [\App\Http\Controllers\AuthController::class, 'loginView'])->name('login');
    $router->post('logar', [\App\Http\Controllers\AuthController::class, 'login'])->name('logar');
    $router->get('logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

    $router->middleware('auth:sanctum')->group(function($router) {
        $router->get('dashboard', [\App\Http\Controllers\AuthController::class, 'privada'])->name('dashboard');
    });
});