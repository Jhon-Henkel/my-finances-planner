<?php

use App\Enums\RouteNameEnum;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ConfigurationsController;
use App\Http\Controllers\CreditCardController;
use App\Http\Controllers\CreditCardTransactionController;
use App\Http\Controllers\FinancialHealthController;
use App\Http\Controllers\FutureGainController;
use App\Http\Controllers\FutureSpentController;
use App\Http\Controllers\UserController;
use App\Modules\Auth\Controller\Login\LoginController;
use App\Modules\Configurations\Controller\ConfigurationsGetController;
use App\Modules\Configurations\Controller\ConfigurationsUpdateController;
use App\Modules\CreditCardInvoice\Controller\CreditCardInvoiceCreateController;
use App\Modules\CreditCardInvoice\Controller\CreditCardInvoiceDeleteController;
use App\Modules\CreditCardInvoice\Controller\CreditCardInvoiceGetController;
use App\Modules\CreditCardInvoice\Controller\CreditCardInvoiceUpdateController;
use App\Modules\CreditCardInvoiceItem\Controller\CreditCardInvoiceItemCreateController;
use App\Modules\CreditCardInvoiceItem\Controller\CreditCardInvoiceItemDeleteController;
use App\Modules\CreditCardInvoiceItem\Controller\CreditCardInvoiceItemUpdateController;
use App\Modules\EarningPlan\Controller\EarningPlanCreateController;
use App\Modules\EarningPlan\Controller\EarningPlanDeleteController;
use App\Modules\EarningPlan\Controller\EarningPlanGetController;
use App\Modules\EarningPlan\Controller\EarningPlanReceiveController;
use App\Modules\EarningPlan\Controller\EarningPlanUpdateController;
use App\Modules\FinancialHealth\Controller\FinancialHealthGetController;
use App\Modules\Movement\Controller\MovementCreateController;
use App\Modules\Movement\Controller\MovementGetController;
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
use App\Modules\SpendingPlan\Controller\SpendingPlanDeleteController;
use App\Modules\SpendingPlan\Controller\SpendingPlanPayController;
use App\Modules\User\Controller\UserGetController;
use App\Modules\User\Controller\UserUpdateController;
use App\Modules\Wallet\Controller\WalletCreateController;
use App\Modules\Wallet\Controller\WalletDeleteController;
use App\Modules\Wallet\Controller\WalletGetController;
use App\Modules\Wallet\Controller\WalletListController;
use App\Modules\Wallet\Controller\WalletUpdateController;
use App\Modules\CreditCard\Controller\CreditCardCreateController;
use App\Modules\CreditCard\Controller\CreditCardListController;
use App\Modules\CreditCard\Controller\CreditCardGetController;
use App\Modules\CreditCard\Controller\CreditCardDeleteController;
use App\Modules\CreditCard\Controller\CreditCardUpdateController;
use Illuminate\Support\Facades\Route;

Route::prefix('v3')->group(function () {
    Route::prefix('')->middleware(['auth:sanctum'])->group(function () {
        Route::prefix('wallet')->group(function () {
            Route::post('', WalletCreateController::class)->name(RouteNameEnum::ApiV3WalletCreate);
            Route::get('', WalletListController::class)->name(RouteNameEnum::ApiV3WalletList);
            Route::prefix('{id}')->group(function () {
                Route::put('', WalletUpdateController::class)->name(RouteNameEnum::ApiV3WalletUpdate);
                Route::get('', WalletGetController::class)->name(RouteNameEnum::ApiV3WalletGet);
                Route::delete('', WalletDeleteController::class)->name(RouteNameEnum::ApiV3WalletDelete);
            });
        });

        Route::prefix('credit-card')->group(function () {
            Route::post('', CreditCardCreateController::class)->name(RouteNameEnum::ApiV3CreditCardCreate);
            Route::get('', CreditCardListController::class)->name(RouteNameEnum::ApiV3CreditCardList);
            Route::prefix('{id}')->group(function () {
                Route::put('', CreditCardUpdateController::class)->name(RouteNameEnum::ApiV3CreditCardUpdate);
                Route::get('', CreditCardGetController::class)->name(RouteNameEnum::ApiV3CreditCardGet);
                Route::delete('', CreditCardDeleteController::class)->name(RouteNameEnum::ApiV3CreditCardDelete);
            });
        });

        Route::prefix('movement')->group(function () {
            Route::post('', MovementCreateController::class)->name(RouteNameEnum::ApiV3MovementCreate);
            Route::get('', \App\Modules\Movement\Controller\MovementListController::class)->name(RouteNameEnum::ApiV3MovementList);
            Route::prefix('{id}')->group(function () {
                Route::get('', MovementGetController::class)->name(RouteNameEnum::ApiV3MovementGet);
                Route::delete('', \App\Modules\Movement\Controller\MovementDeleteController::class)->name(RouteNameEnum::ApiV3MovementDelete);
                Route::put('', \App\Modules\Movement\Controller\MovementUpdateController::class)->name(RouteNameEnum::ApiV3MovementUpdate);
            });

            Route::prefix('transfer')->group(function () {
                Route::post('', \App\Modules\Movement\Controller\MovementTransferCreateController::class)->name(RouteNameEnum::ApiV3MovementTransferCreate);
                Route::delete('{id}', \App\Modules\Movement\Controller\MovementTransferDeleteController::class)->name(RouteNameEnum::ApiV3MovementTransferDelete);
            });
        });

        Route::prefix('spending-plan')->group(function () {
            Route::post('', \App\Modules\SpendingPlan\Controller\SpendingPlanCreateController::class)->name(RouteNameEnum::ApiV3SpendingPlanCreate);
            Route::get('', \App\Modules\SpendingPlan\Controller\SpendingPlanListController::class)->name(RouteNameEnum::ApiV3SpendingPlanList);
            Route::post('pay', SpendingPlanPayController::class)->name(RouteNameEnum::ApiV3SpendingPlanPay);
            Route::prefix('{id}')->group(function () {
                Route::get('', \App\Modules\SpendingPlan\Controller\SpendingPlanGetController::class)->name(RouteNameEnum::ApiV3SpendingPlanGet);
                Route::delete('', SpendingPlanDeleteController::class)->name(RouteNameEnum::ApiV3SpendingPlanDelete);
                Route::put('', \App\Modules\SpendingPlan\Controller\SpendingPlanUpdateController::class)->name(RouteNameEnum::ApiV3SpendingPlanUpdate);
            });
        });

        Route::prefix('earning-plan')->group(function () {
            Route::post('', EarningPlanCreateController::class)->name(RouteNameEnum::ApiV3EarningPlanCreate);
            Route::get('', \App\Modules\EarningPlan\Controller\EarningPlanListController::class)->name(RouteNameEnum::ApiV3EarningPlanList);
            Route::post('receive', EarningPlanReceiveController::class)->name(RouteNameEnum::ApiV3EarningPlanReceive);
            Route::prefix('{id}')->group(function () {
                Route::get('', EarningPlanGetController::class)->name(RouteNameEnum::ApiV3EarningPlanGet);
                Route::delete('', EarningPlanDeleteController::class)->name(RouteNameEnum::ApiV3EarningPlanDelete);
                Route::put('', EarningPlanUpdateController::class)->name(RouteNameEnum::ApiV3EarningPlanUpdate);
            });
        });

        Route::prefix('credit-card-invoice')->group(function () {
            Route::post('', CreditCardInvoiceCreateController::class)->name(RouteNameEnum::ApiV3CreditCardInvoiceCreate);
            Route::get('', \App\Modules\CreditCardInvoice\Controller\CreditCardInvoiceListController::class)->name(RouteNameEnum::ApiV3CreditCardInvoiceList);
            Route::prefix('{id}')->group(function () {
                Route::get('', CreditCardInvoiceGetController::class)->name(RouteNameEnum::ApiV3CreditCardInvoiceGet);
                Route::put('', CreditCardInvoiceUpdateController::class)->name(RouteNameEnum::ApiV3CreditCardInvoiceUpdate);
                Route::delete('', CreditCardInvoiceDeleteController::class)->name(RouteNameEnum::ApiV3CreditCardInvoiceDelete);
            });
        });

        Route::prefix('credit-card-invoice-item')->group(function () {
            Route::post('', CreditCardInvoiceItemCreateController::class)->name(RouteNameEnum::ApiV3CreditCardInvoiceItemCreate);
            Route::prefix('{id}')->group(function () {
                Route::put('', CreditCardInvoiceItemUpdateController::class)->name(RouteNameEnum::ApiV3CreditCardInvoiceItemUpdate);
                Route::delete('', CreditCardInvoiceItemDeleteController::class)->name(RouteNameEnum::ApiV3CreditCardInvoiceItemDelete);
            });
        });

        Route::get('financial-health', FinancialHealthGetController::class)->name(RouteNameEnum::ApiV3FinancialHealthGet);

        Route::prefix('user')->group(function () {
            Route::get('{id}', UserGetController::class)->name(RouteNameEnum::ApiV3UserGet);
            Route::put('{id}', UserUpdateController::class)->name(RouteNameEnum::ApiV3UserUpdate);
        });

        Route::prefix('configurations')->group(function () {
            Route::get('', ConfigurationsGetController::class)->name(RouteNameEnum::ApiV3ConfigurationsGet);
            Route::put('', ConfigurationsUpdateController::class)->name(RouteNameEnum::ApiV3ConfigurationsUpdate);
        });

        Route::get('market-planner', \App\Modules\MarketPlanner\Controller\MarketPlannerShowController::class)->name(RouteNameEnum::ApiV3MarketPlannerShow);
    });

    Route::prefix('auth')->group(function () {
        Route::post('login', LoginController::class)->name(RouteNameEnum::ApiV3AuthLogin);
    });
});

/**
 * --------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
 * --------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
 * --------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
 * --------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
 * @deprecated - Migrado para V3
 * --------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
 * --------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
 * --------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
 * --------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
 */
Route::prefix('')->middleware('auth.api:api')->group(function () {
    Route::prefix('v2')->group(function () {
        Route::prefix('spending-plan')->group(function () {
            Route::get('', SpendingPlanListController::class)->name(RouteNameEnum::ApiSpendingPlanList->value);
            Route::post('', SpendingPlanCreateController::class)->name(RouteNameEnum::ApiSpendingPlanInsert->value);
            Route::put('{id}', SpendingPlanUpdateController::class)->name(RouteNameEnum::ApiSpendingPlanUpdate->value);
            Route::get('{id}', SpendingPlanGetController::class)->name(RouteNameEnum::ApiSpendingPlanGet->value);
        });

        Route::prefix('earnings-plan')->group(function () {
            Route::get('', EarningPlanListController::class)->name(RouteNameEnum::ApiEarningPlanList->value);
        });

        Route::prefix('market-planner')->group(function () {
            Route::get('show-details', MarketPlannerShowController::class)->name(RouteNameEnum::ApiMarketPlannerShow->value);
        });

        Route::prefix('credit-card')->group(function () {
            Route::prefix('invoice')->group(function () {
                Route::get('{credit_card_id}', CreditCardInvoiceListController::class)->name(RouteNameEnum::ApiCreditCardInvoiceList->value);
            });
        });

        Route::prefix('movement')->group(function () {
            Route::prefix('transfer')->group(function () {
                Route::post('', MovementTransferCreateController::class)->name(RouteNameEnum::ApiMovementInsertTransfer->value);
                Route::delete('{id}', MovementTransferDeleteController::class)->name(RouteNameEnum::ApiMovementDeleteTransfer->value);
            });
            Route::get('', MovementListController::class)->name(RouteNameEnum::ApiMovementList->value);
            Route::post('', CreateMovementController::class)->name(RouteNameEnum::ApiMovementInsert->value);
            Route::put('{id}', MovementUpdateController::class)->name(RouteNameEnum::ApiMovementUpdate->value);
            Route::delete('{id}', MovementDeleteController::class)->name(RouteNameEnum::ApiMovementDelete->value);
        });
    });

    Route::prefix('wallet')->group(function () {
        Route::get('{id}', [WalletController::class, 'show'])->name(RouteNameEnum::ApiWalletShow->value);
        Route::get('', [WalletController::class, 'index'])->name(RouteNameEnum::ApiWalletIndex->value);
        Route::post('', [WalletController::class, 'insert'])->name(RouteNameEnum::ApiWalletInsert->value);
        Route::put('/{id}', [WalletController::class, 'update'])->name(RouteNameEnum::ApiWalletUpdate->value);
        Route::delete('/{id}', [WalletController::class, 'delete'])->name(RouteNameEnum::ApiWalletDelete->value);
    });

    Route::prefix('credit-card')->group(function () {
        Route::prefix('transaction')->group(function () {
            Route::get('/{id}', [CreditCardTransactionController::class, 'show'])->name(RouteNameEnum::ApiCreditCardTransactionShow->value);
            Route::post('', [CreditCardTransactionController::class, 'insert'])->name(RouteNameEnum::ApiCreditCardTransactionInsert->value);
            Route::put('/{id}', [CreditCardTransactionController::class, 'update'])->name(RouteNameEnum::ApiCreditCardTransactionUpdate->value);
            Route::delete('/{id}', [CreditCardTransactionController::class, 'delete'])->name(RouteNameEnum::ApiCreditCardTransactionDelete->value);
        });

        Route::prefix('{id}/invoices')->group(function () {
            Route::put('/{walletId}', [CreditCardTransactionController::class, 'payInvoice'])->name(RouteNameEnum::ApiCreditCardPayInvoice->value);
        });

        Route::get('', [CreditCardController::class, 'index'])->name(RouteNameEnum::ApiCreditCardIndex->value);
        Route::post('', [CreditCardController::class, 'insert'])->name(RouteNameEnum::ApiCreditCardInsert->value);
        Route::put('/{id}', [CreditCardController::class, 'update'])->name(RouteNameEnum::ApiCreditCardUpdate->value);
        Route::delete('/{id}', [CreditCardController::class, 'delete'])->name(RouteNameEnum::ApiCreditCardDelete->value);
    });

    Route::prefix('future-gain')->group(function () {
        Route::get('/{id}', [FutureGainController::class, 'show'])->name(RouteNameEnum::ApiFutureGainShow->value);
        Route::post('', [FutureGainController::class, 'insert'])->name(RouteNameEnum::ApiFutureGainInsert->value);
        Route::put('/{id}', [FutureGainController::class, 'update'])->name(RouteNameEnum::ApiFutureGainUpdate->value);
        Route::delete('/{id}', [FutureGainController::class, 'delete'])->name(RouteNameEnum::ApiFutureGainDelete->value);
        Route::post('/{id}/receive', [FutureGainController::class, 'receive'])->name(RouteNameEnum::ApiFutureGainReceive->value);
    });

    Route::prefix('future-spent')->group(function () {
        Route::post('/{id}/pay', [FutureSpentController::class, 'paySpent'])->name(RouteNameEnum::ApiFutureSpentPay->value);
        Route::delete('/{id}', [FutureSpentController::class, 'delete'])->name(RouteNameEnum::ApiFutureSpentDelete->value);
    });

    Route::prefix('configurations')->group(function () {
        Route::put('', [ConfigurationsController::class, 'updateConfigs'])->name(RouteNameEnum::ApiConfigurationUpdate->value);
        Route::get('', [ConfigurationsController::class, 'index'])->name(RouteNameEnum::ApiConfigurationIndex->value);
    });

    Route::prefix('user')->group(function () {
        Route::get('/{id}', [UserController::class, 'show'])->name(RouteNameEnum::ApiUserShow->value);
        Route::put('/{id}', [UserController::class, 'update'])->name(RouteNameEnum::ApiUserUpdate->value);
    });

    Route::prefix('financial-health')->group(function () {
        Route::get('/filter', [FinancialHealthController::class, 'indexFiltered'])->name(RouteNameEnum::ApiFinancialHealthIndexFiltered->value);
    });
});

Route::post('auth', [AuthController::class, 'auth'])->name(RouteNameEnum::ApiMakeLogin->value);
Route::get('logout', [AuthController::class, 'logout'])->name(RouteNameEnum::ApiLogout->value);
/**
 * <---------------------------------------------------------------------------------------------------------------------------------------------------------------------------
 * <---------------------------------------------------------------------------------------------------------------------------------------------------------------------------
 * <---------------------------------------------------------------------------------------------------------------------------------------------------------------------------
 * <---------------------------------------------------------------------------------------------------------------------------------------------------------------------------
 */

Route::prefix('/mfp')->middleware('auth.mfp:api')->group(function () {
    Route::prefix('/market-control-app')->group(function () {
        Route::get('/wallets', GetWalletListController::class)->name(RouteNameEnum::ApiMarketControlWalletList->value);
        Route::post('/movement', MarkSpentController::class)->name(RouteNameEnum::ApiMarketControlMarkSpent->value);
    });
});
