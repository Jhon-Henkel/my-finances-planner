<?php

use App\Infra\Enum\RouteNameEnum;
use App\Modules\Auth\Controller\Login\LoginController;
use App\Modules\FinancialPlan\Controller\FinancialPlanCreateController;
use App\Modules\FinancialPlan\Controller\FinancialPlanGetController;
use App\Modules\FinancialPlan\Controller\FinancialPlanListController;
use App\Modules\Movement\Controller\MovementCreateController;
use App\Modules\Movement\Controller\MovementDeleteController;
use App\Modules\Movement\Controller\MovementGetController;
use App\Modules\Movement\Controller\MovementListController;
use App\Modules\Movement\Controller\MovementUpdateController;
use App\Modules\Movement\Controller\Transfer\MovementTransferCreateController;
use App\Modules\Movement\Controller\Transfer\MovementTransferDeleteController;
use App\Modules\Wallet\Controller\WalletCreateController;
use App\Modules\Wallet\Controller\WalletDeleteController;
use App\Modules\Wallet\Controller\WalletGetController;
use App\Modules\Wallet\Controller\WalletListController;
use App\Modules\Wallet\Controller\WalletUpdateController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('login', LoginController::class)->name(RouteNameEnum::ApiV3AuthLogin);
});

Route::prefix('v3')->middleware(['auth:sanctum'])->group(function () {
    Route::prefix('wallet')->group(function () {
        Route::get('', WalletListController::class)->name(RouteNameEnum::ApiV3WalletList);
        Route::post('', WalletCreateController::class)->name(RouteNameEnum::ApiV3WalletCreate);
        Route::prefix('{id}')->group(function () {
            Route::get('', WalletGetController::class)->name(RouteNameEnum::ApiV3WalletGet);
            Route::put('', WalletUpdateController::class)->name(RouteNameEnum::ApiV3WalletUpdate);
            Route::delete('', WalletDeleteController::class)->name(RouteNameEnum::ApiV3WalletDelete);
        });
    });

    Route::prefix('movement')->group(function () {
        Route::prefix('transfer')->group(function () {
            Route::post('', MovementTransferCreateController::class)->name(RouteNameEnum::ApiV3MovementTransferCreate);
            Route::delete('{id}', MovementTransferDeleteController::class)->name(RouteNameEnum::ApiV3MovementTransferDelete);
        });

        Route::get('', MovementListController::class)->name(RouteNameEnum::ApiV3MovementList);
        Route::post('', MovementCreateController::class)->name(RouteNameEnum::ApiV3MovementCreate);
        Route::prefix('{id}')->group(function () {
            Route::get('', MovementGetController::class)->name(RouteNameEnum::ApiV3MovementGet);
            Route::put('', MovementUpdateController::class)->name(RouteNameEnum::ApiV3MovementUpdate);
            Route::delete('', MovementDeleteController::class)->name(RouteNameEnum::ApiV3MovementDelete);
        });
    });

    Route::prefix('financial-plan')->group(function () {
        Route::get('', FinancialPlanListController::class)->name(RouteNameEnum::ApiV3FinancialPlanList);
        Route::post('', FinancialPlanCreateController::class)->name(RouteNameEnum::ApiV3FinancialPlanCreate);
        Route::prefix('{id}')->group(function () {
            Route::get('', FinancialPlanGetController::class)->name(RouteNameEnum::ApiV3FinancialPlanGet);
        });
    });
});
