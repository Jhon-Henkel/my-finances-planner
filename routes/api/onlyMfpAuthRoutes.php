<?php

use App\Enums\RouteEnum;
use App\Http\Controllers\Subscribe\SubscribeController;
use App\Http\Controllers\User\UserRegisterController;
use App\Modules\MarketControl\Controller\GetWalletListController;
use App\Modules\MarketControl\Controller\MarkSpentController;
use Illuminate\Support\Facades\Route;

// Rotas que requer somente token MFP
return function () {
    Route::prefix('/mfp')->middleware('auth.mfp:api')->group(function () {
        Route::prefix('/subscription')->group(function () {
            Route::post('/update-account', [SubscribeController::class, 'updateAccount'])
                ->name(RouteEnum::ApiSubscribeUpdateAccount->value);
        });

        Route::prefix('/user')->group(function () {
            Route::prefix('/register')->group(function () {
                Route::post('/step-one', [UserRegisterController::class, 'registerStepOne'])
                    ->name(RouteEnum::MfpUserRegisterStepOne->value);
                Route::post('/step-two', [UserRegisterController::class, 'registerStepTwo'])
                    ->name(RouteEnum::MfpUserRegisterStepTwo->value);
                Route::post('/activate/{hash}', [UserRegisterController::class, 'registerStepThree'])
                    ->name(RouteEnum::MfpUserRegisterStepThree->value);
            });
        });

        Route::prefix('/market-control-app')->group(function () {
            Route::get('/wallets', GetWalletListController::class)
                ->name(RouteEnum::ApiMarketControlWalletList->value);

            Route::post('/movement', MarkSpentController::class)
                ->name(RouteEnum::ApiMarketControlMarkSpent->value);
        });
    });
};
