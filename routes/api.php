<?php

use App\Enums\RouteEnum;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ConfigurationsController;
use App\Http\Controllers\CreditCardController;
use App\Http\Controllers\CreditCardTransactionController;
use App\Http\Controllers\FinancialHealthController;
use App\Http\Controllers\FutureGainController;
use App\Http\Controllers\FutureSpentController;
use App\Http\Controllers\UserController;
use App\Modules\Old\CreditCardInvoice\Controller\List\CreditCardInvoiceListController;
use App\Modules\Old\EarningsPlan\Controller\List\EarningPlanListController;
use App\Modules\Old\MarketControl\Controller\GetWalletListController;
use App\Modules\Old\MarketControl\Controller\MarkSpentController;
use App\Modules\Old\MarketPlanner\Controller\Show\MarketPlannerShowController;
use App\Modules\Old\Movements\Controller\Delete\MovementDeleteController;
use App\Modules\Old\Movements\Controller\DeleteTransfer\MovementTransferDeleteController;
use App\Modules\Old\Movements\Controller\Insert\CreateMovementController;
use App\Modules\Old\Movements\Controller\InsertTransfer\MovementTransferCreateController;
use App\Modules\Old\Movements\Controller\List\MovementListController;
use App\Modules\Old\Movements\Controller\Update\MovementUpdateController;
use App\Modules\Old\SpendingPlan\Controller\Get\SpendingPlanGetController;
use App\Modules\Old\SpendingPlan\Controller\Insert\SpendingPlanCreateController;
use App\Modules\Old\SpendingPlan\Controller\List\SpendingPlanListController;
use App\Modules\Old\SpendingPlan\Controller\Update\SpendingPlanUpdateController;
use App\Modules\Old\Wallet\Controller\WalletController;
use Illuminate\Support\Facades\Route;

Route::prefix('')->middleware('auth.api:api')->group(function () {
    Route::prefix('v2')->group(function () {
        Route::prefix('spending-plan')->group(function () {
            Route::get('', SpendingPlanListController::class)->name(RouteEnum::ApiSpendingPlanList->value);
            Route::post('', SpendingPlanCreateController::class)->name(RouteEnum::ApiSpendingPlanInsert->value);
            Route::put('{id}', SpendingPlanUpdateController::class)->name(RouteEnum::ApiSpendingPlanUpdate->value);
            Route::get('{id}', SpendingPlanGetController::class)->name(RouteEnum::ApiSpendingPlanGet->value);
        });
        Route::prefix('earnings-plan')->group(function () {
            Route::get('', EarningPlanListController::class)->name(RouteEnum::ApiEarningPlanList->value);
        });
        Route::prefix('market-planner')->group(function () {
            Route::get('show-details', MarketPlannerShowController::class)->name(RouteEnum::ApiMarketPlannerShow->value);
        });
        Route::prefix('credit-card')->group(function () {
            Route::prefix('invoice')->group(function () {
                Route::get('{credit_card_id}', CreditCardInvoiceListController::class)->name(RouteEnum::ApiCreditCardInvoiceList->value);
            });
        });
        Route::prefix('movement')->group(function () {
            Route::prefix('transfer')->group(function () {
                Route::post('', MovementTransferCreateController::class)->name(RouteEnum::ApiMovementInsertTransfer->value);
                Route::delete('{id}', MovementTransferDeleteController::class)->name(RouteEnum::ApiMovementDeleteTransfer->value);
            });
            Route::get('', MovementListController::class)->name(RouteEnum::ApiMovementList->value);
            Route::post('', CreateMovementController::class)->name(RouteEnum::ApiMovementInsert->value);
            Route::put('{id}', MovementUpdateController::class)->name(RouteEnum::ApiMovementUpdate->value);
            Route::delete('{id}', MovementDeleteController::class)->name(RouteEnum::ApiMovementDelete->value);
        });
    });

    Route::prefix('wallet')->group(function () {
        Route::get('{id}', [WalletController::class, 'show'])
            ->name(RouteEnum::ApiWalletShow->value);
        Route::get('', [WalletController::class, 'index'])
            ->name(RouteEnum::ApiWalletIndex->value);
        Route::post('', [WalletController::class, 'insert'])
            ->name(RouteEnum::ApiWalletInsert->value);
        Route::put('/{id}', [WalletController::class, 'update'])
            ->name(RouteEnum::ApiWalletUpdate->value);
        Route::delete('/{id}', [WalletController::class, 'delete'])
            ->name(RouteEnum::ApiWalletDelete->value);
    });

    Route::prefix('credit-card')->group(function () {
        Route::prefix('transaction')->group(function () {
            Route::get('/{id}', [CreditCardTransactionController::class, 'show'])
                ->name(RouteEnum::ApiCreditCardTransactionShow->value);
            Route::post('', [CreditCardTransactionController::class, 'insert'])
                ->name(RouteEnum::ApiCreditCardTransactionInsert->value);
            Route::put('/{id}', [CreditCardTransactionController::class, 'update'])
                ->name(RouteEnum::ApiCreditCardTransactionUpdate->value);
            Route::delete('/{id}', [CreditCardTransactionController::class, 'delete'])
                ->name(RouteEnum::ApiCreditCardTransactionDelete->value);
        });

        Route::prefix('{id}/invoices')->group(function () {
            Route::put('/{walletId}', [CreditCardTransactionController::class, 'payInvoice'])
                ->name(RouteEnum::ApiCreditCardPayInvoice->value);
        });

        Route::get('', [CreditCardController::class, 'index'])
            ->name(RouteEnum::ApiCreditCardIndex->value);
        Route::post('', [CreditCardController::class, 'insert'])
            ->name(RouteEnum::ApiCreditCardInsert->value);
        Route::put('/{id}', [CreditCardController::class, 'update'])
            ->name(RouteEnum::ApiCreditCardUpdate->value);
        Route::delete('/{id}', [CreditCardController::class, 'delete'])
            ->name(RouteEnum::ApiCreditCardDelete->value);
    });

    Route::prefix('future-gain')->group(function () {
        Route::get('/{id}', [FutureGainController::class, 'show'])
            ->name(RouteEnum::ApiFutureGainShow->value);
        Route::post('/{id}/receive', [FutureGainController::class, 'receive'])
            ->name(RouteEnum::ApiFutureGainReceive->value);
        Route::post('', [FutureGainController::class, 'insert'])
            ->name(RouteEnum::ApiFutureGainInsert->value);
        Route::put('/{id}', [FutureGainController::class, 'update'])
            ->name(RouteEnum::ApiFutureGainUpdate->value);
        Route::delete('/{id}', [FutureGainController::class, 'delete'])
            ->name(RouteEnum::ApiFutureGainDelete->value);
    });

    Route::prefix('future-spent')->group(function () {
        Route::post('/{id}/pay', [FutureSpentController::class, 'paySpent'])
            ->name(RouteEnum::ApiFutureSpentPay->value);
        Route::delete('/{id}', [FutureSpentController::class, 'delete'])
            ->name(RouteEnum::ApiFutureSpentDelete->value);
    });

    Route::prefix('configurations')->group(function () {
        Route::put('', [ConfigurationsController::class, 'updateConfigs'])
            ->name(RouteEnum::ApiConfigurationUpdate->value);
        Route::get('', [ConfigurationsController::class, 'index'])
            ->name(RouteEnum::ApiConfigurationIndex->value);
    });

    Route::prefix('user')->group(function () {
        Route::get('/{id}', [UserController::class, 'show'])
            ->name(RouteEnum::ApiUserShow->value);
        Route::put('/{id}', [UserController::class, 'update'])
            ->name(RouteEnum::ApiUserUpdate->value);
    });

    Route::prefix('financial-health')->group(function () {
        Route::get('/filter', [FinancialHealthController::class, 'indexFiltered'])
            ->name(RouteEnum::ApiFinancialHealthIndexFiltered->value);
    });
});

Route::prefix('/mfp')->middleware('auth.mfp:api')->group(function () {
    Route::prefix('/market-control-app')->group(function () {
        Route::get('/wallets', GetWalletListController::class)
            ->name(RouteEnum::ApiMarketControlWalletList->value);

        Route::post('/movement', MarkSpentController::class)
            ->name(RouteEnum::ApiMarketControlMarkSpent->value);
    });
});

Route::post('auth', [AuthController::class, 'auth'])
    ->name(RouteEnum::ApiMakeLogin->value);

Route::get('logout', [AuthController::class, 'logout'])
    ->name(RouteEnum::ApiLogout->value);
