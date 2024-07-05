<?php

use App\Enums\RouteEnum;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\UserController;
use App\Tools\Request\RequestTools;
use Illuminate\Support\Facades\Route;

/** @var Route $router */
$router->prefix('/')->group(function ($router) {
    $router->prefix('auth')->group(function () use ($router) {
        $router->get('/verify', [AuthController::class, 'verifyIsAuthenticated'])->name(RouteEnum::WebVerifyToken->value);
        $router->post('', [AuthController::class, 'auth'])->name(RouteEnum::WebMakeLogin->value);
    });

    $router->get('logout', [AuthController::class, 'logout'])->name(RouteEnum::WebLogout->value);
    $router->get('send-test-email', [MailController::class, 'sendTestEmail'])->name(RouteEnum::WebSendTestEmail->value);
    $router->get('active-user/{verifyHash}', [UserController::class, 'activeUser'])->name(RouteEnum::WebActiveUser->value);

    if (RequestTools::isApplicationInDevelopMode()) {
        $router->prefix('develop')->group(function () use ($router) {
            $router->get('get-tokens', [UserController::class, 'developGetTokens'])->name(RouteEnum::DevelopGetTokens->value);
        });
    };

    $router->prefix('v2')->group(function () use ($router) {
        $router->get('', function () {
            return view('indexV2');
        });
        $router->get('/{any}', function () {
            return view('indexV2');
        })->where('any', '.*');
    });


    $router->get('{any}', function () {
        return view('index');
    })->where('any', '.*');
});