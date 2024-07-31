<?php

use App\Enums\RouteEnum;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\UserController;
use App\Tools\Request\RequestTools;
use Illuminate\Support\Facades\Route;

/** @var Route $router */
Route::prefix('/')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('', [AuthController::class, 'auth'])
            ->name(RouteEnum::WebMakeLogin->value);
    });
    Route::get('logout', [AuthController::class, 'logout'])
        ->name(RouteEnum::WebLogout->value);
    Route::get('send-test-email', [MailController::class, 'sendTestEmail'])
        ->name(RouteEnum::WebSendTestEmail->value);
    Route::get('active-user/{verifyHash}', [UserController::class, 'activeUser'])
        ->name(RouteEnum::WebActiveUser->value);
    if (RequestTools::isApplicationInDevelopMode()) {
        Route::prefix('develop')->group(function () {
            Route::get('get-tokens', [UserController::class, 'developGetTokens'])
                ->name(RouteEnum::DevelopGetTokens->value);
        });
    }

    Route::prefix('v2')->group(function () {
        Route::get('', function () {
            return view('indexV2');
        });
        Route::get('/{any}', function () {
            return view('indexV2');
        })->where('any', '.*');
    });

    Route::get('{any}', function () {
        return redirect('/v2/login');
    })->where('any', '.*');
});
