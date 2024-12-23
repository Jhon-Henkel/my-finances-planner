<?php

use App\Enums\RouteEnum;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Subscribe\SubscribeController;
use App\Http\Controllers\User\UserRegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Rotas que não requer autenticação
return function () {
    Route::prefix('notification')->group(function () {
        Route::prefix('stripe')->group(function () {
            Route::post('checkout-session-complete', [SubscribeController::class, 'paymentCompletedNotification'])
                ->name(RouteEnum::ApiSubscribePaymentComplete->value);
        });
    });

    Route::post('auth', [AuthController::class, 'auth'])
        ->name(RouteEnum::ApiMakeLogin->value);

    Route::post('user/register', [UserRegisterController::class, 'registerStepZero'])
        ->name(RouteEnum::ApiUserRegisterStepZero->value);

    Route::get('logout', [AuthController::class, 'logout'])
        ->name(RouteEnum::ApiLogout->value);

    Route::get('active-user/{verifyHash}', [UserController::class, 'activeUser'])
        ->name(RouteEnum::ApiActiveUser->value);
};
