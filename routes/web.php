<?php

use App\Enums\RouteEnum;
use App\Enums\ViewEnum;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FutureGainController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

/** @var Route $router */
$router->prefix('/')->group(function ($router){
    // todo quando logar, redirecionar para a página que tentou acessar, o laravel ja tem middleware pronto para isso https://laravel.com/docs/10.x/authentication#password-confirmation-protecting-routes
    $router->get('login', [AuthController::class, 'renderLoginView'])->name(RouteEnum::WEB_LOGIN);
    $router->post('make-login', [AuthController::class, 'login'])->name(RouteEnum::WEB_MAKE_LOGIN);
    $router->get('logout', [AuthController::class, 'logout'])->name(RouteEnum::WEB_LOGOUT);
    $router->get('is-user-logged', [AuthController::class, 'isUserLogged'])->name(RouteEnum::WEB_IS_USER_LOGGED);
    $router->get('get-mfp-token', [AuthController::class, 'getMfpToken'])->name(RouteEnum::WEB_GET_MFP_TOKEN);;
    $router->middleware('auth:sanctum')->group(function($router) {
        // todo transformar essa rota para um baseRoute, onde temos o base.blade.php, renomear para index, tanto o arquivo quanto a rota
        $router->get('dashboard', [DashboardController::class, 'renderDashboardView'])->name(RouteEnum::WEB_DASHBOARD);
        $router->get('{any}', function () {
            return view(ViewEnum::VIEW_BASE);
        })->where('any', '.*');
        // todo essas rotas vão ser gerenciadas no vue
//        $router->prefix('/movement')->group(function ($router) {
//            $router->get('', [MovementController::class, 'renderMovementView'])->name(RouteEnum::WEB_MOVEMENT);
//            $router->post('delete-movement/{id}', [MovementController::class, 'deleteFromCrud'])->name(RouteEnum::WEB_DELETE_MOVEMENT);
//            $router->post('insert-spent', [MovementController::class, 'insertSpent'])->name(RouteEnum::WEB_INSERT_SPENT);
//            $router->post('insert-gain', [MovementController::class, 'insertGain'])->name(RouteEnum::WEB_INSERT_GAIN);
//            $router->post('insert-transfer', [MovementController::class, 'insertTransfer'])->name(RouteEnum::WEB_INSERT_TRANSFER);
//        });
//        $router->prefix('/future-gain')->group(function ($router) {
//            $router->get('', [FutureGainController::class, 'renderFutureGainView'])->name(RouteEnum::WEB_FUTURE_GAIN);
//        });
    });
});