<?php

use App\Enums\RouteEnum;
use App\Http\Controllers\ConfigurationsController;
use App\Http\Controllers\CreditCardController;
use App\Http\Controllers\CreditCardTransactionController;
use App\Http\Controllers\FinancialHealthController;
use App\Http\Controllers\FutureGainController;
use App\Http\Controllers\FutureSpentController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\Plan\PlanController;
use App\Http\Controllers\Subscribe\SubscribeController;
use App\Http\Controllers\UserController;
use App\Modules\CreditCardInvoice\Controller\List\CreditCardInvoiceListController;
use App\Modules\EarningsPlan\Controller\List\EarningPlanListController;
use App\Modules\MarketPlanner\Controller\Show\MarketPlannerShowController;
use App\Modules\Movements\Controller\Insert\InsertMovementController;
use App\Modules\Movements\Controller\Update\MovementUpdateController;
use App\Modules\SpendingPlan\Controller\Get\SpendingPlanGetController;
use App\Modules\SpendingPlan\Controller\Insert\SpendingPlanInsertController;
use App\Modules\SpendingPlan\Controller\List\SpendingPlanListController;
use App\Modules\SpendingPlan\Controller\Update\SpendingPlanUpdateController;
use App\Modules\Wallet\Controller\WalletController;
use Illuminate\Support\Facades\Route;

// Rotas que requer autenticação JWT e token MFP
return function () {
    Route::prefix('')->middleware('auth.api:api')->group(function () {
        Route::prefix('v2')->group(function () {
            Route::prefix('spending-plan')->group(function () {
                Route::get('', SpendingPlanListController::class)->name(RouteEnum::ApiSpendingPlanList->value);
                Route::post('', SpendingPlanInsertController::class)->name(RouteEnum::ApiSpendingPlanInsert->value);
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
                Route::post('', InsertMovementController::class)->name(RouteEnum::ApiMovementInsert->value);
                Route::put('{id}', MovementUpdateController::class)->name(RouteEnum::ApiMovementUpdate->value);
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

        Route::prefix('movement')->group(function () {
            Route::prefix('transfer')->group(function () {
                Route::post('', [MovementController::class, 'insertTransfer'])
                    ->name(RouteEnum::ApiMovementInsertTransfer->value);
                Route::delete('/{id}', [MovementController::class, 'deleteTransfer'])
                    ->name(RouteEnum::ApiMovementDeleteTransfer->value);
            });

            Route::get('', [MovementController::class, 'index'])
                ->name(RouteEnum::ApiMovementIndex->value);
            Route::get('/filter', [MovementController::class, 'indexFiltered'])
                ->name(RouteEnum::ApiMovementIndexFiltered->value);
            Route::delete('/{id}', [MovementController::class, 'delete'])
                ->name(RouteEnum::ApiMovementDelete->value);
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

        Route::prefix('subscription')->group(function () {
            Route::post('/subscribe', [SubscribeController::class, 'subscribe'])
                ->name(RouteEnum::ApiSubscribe->value);
            Route::post('/cancel', [SubscribeController::class, 'cancel'])
                ->name(RouteEnum::ApiCancelSubscribe->value);
        });

        Route::prefix('plan')->group(function () {
            Route::get('', [PlanController::class, 'index'])
                ->name(RouteEnum::ApiPlanIndex->value);
        });
    });
};
