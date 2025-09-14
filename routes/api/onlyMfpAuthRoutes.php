<?php

use App\Enums\RouteEnum;
use App\Http\Controllers\Subscribe\SubscribeController;
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

        Route::prefix('/market-control-app')->group(function () {
            Route::get('/wallets', GetWalletListController::class)
                ->name(RouteEnum::ApiMarketControlWalletList->value);

            Route::post('/movement', MarkSpentController::class)
                ->name(RouteEnum::ApiMarketControlMarkSpent->value);
        });
    });
};
