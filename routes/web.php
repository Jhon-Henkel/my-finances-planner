<?php

use App\Enums\RouteEnum;
use App\Enums\ViewEnum;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/** @var Route $router */
$router->prefix('/')->group(function ($router) {
    $router->prefix('auth')->group(function () use ($router) {
        $router->get('/verify', [AuthController::class, 'verifyIsAuthenticated'])->name(RouteEnum::WEB_VERIFY_TOKEN);
        $router->post('', [AuthController::class, 'auth'])->name(RouteEnum::WEB_MAKE_LOGIN);
    });
    $router->get('logout', [AuthController::class, 'logout'])->name(RouteEnum::WEB_LOGOUT);
    $router->get('send-test-email', [MailController::class, 'sendTestEmail'])->name(RouteEnum::WEB_SEND_TEST_EMAIL);
    $router->get('active-user/{verifyHash}', [UserController::class, 'activeUser'])->name(RouteEnum::WEB_ACTIVE_USER);
    $router->get('{any}', function () {
        return view(ViewEnum::VIEW_BASE);
    })->where('any', '.*');
});