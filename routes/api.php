<?php

use App\Enums\RouteEnum;
use App\Http\Controllers\CreditCardController;
use App\Http\Controllers\CreditCardTransactionController;
use App\Http\Controllers\FinancialHealthController;
use App\Http\Controllers\FutureGainController;
use App\Http\Controllers\FutureSpentController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\PanoramaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

Route::prefix('/')->middleware('auth.api:api')->group(function () {

    Route::prefix('wallet')->group(function () {
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
        });

        Route::get('', [MovementController::class, 'index'])
            ->name(RouteEnum::ApiMovementIndex->value);
        Route::get('/filter', [MovementController::class, 'indexFiltered'])
            ->name(RouteEnum::ApiMovementIndexFiltered->value);
        Route::post('', [MovementController::class, 'insert'])
            ->name(RouteEnum::ApiMovementInsert->value);
        Route::put('/{id}', [MovementController::class, 'update'])
            ->name(RouteEnum::ApiMovementUpdate->value);
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
            Route::get('', [CreditCardTransactionController::class, 'invoices'])
                ->name(RouteEnum::ApiCreditCardInvoices->value);
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
        Route::get('next-six-months', [FutureGainController::class, 'nextSixMonths'])
            ->name(RouteEnum::ApiFutureGainNextSixMonths->value);
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
        Route::get('/{id}', [FutureSpentController::class, 'show'])
            ->name(RouteEnum::ApiFutureSpentShow->value);
        Route::post('', [FutureSpentController::class, 'insert'])
            ->name(RouteEnum::ApiFutureSpentInsert->value);
        Route::post('/{id}/pay', [FutureSpentController::class, 'paySpent'])
            ->name(RouteEnum::ApiFutureSpentPay->value);
        Route::put('/{id}', [FutureSpentController::class, 'update'])
            ->name(RouteEnum::ApiFutureSpentUpdate->value);
        Route::delete('/{id}', [FutureSpentController::class, 'delete'])
            ->name(RouteEnum::ApiFutureSpentDelete->value);
    });

    Route::prefix('user')->group(function () {
        Route::get('/{id}', [UserController::class, 'show'])
            ->name(RouteEnum::ApiUserShow->value);
        Route::put('/{id}', [UserController::class, 'update'])
            ->name(RouteEnum::ApiUserUpdate->value);
    });

    Route::prefix('panorama')->group(function () {
        Route::get('', [PanoramaController::class, 'getPanoramaData'])
            ->name(RouteEnum::ApiPanoramaIndex->value);
    });

    Route::prefix('financial-health')->group(function () {
        Route::get('/filter', [FinancialHealthController::class, 'indexFiltered'])
            ->name(RouteEnum::ApiFinancialHealthIndexFiltered->value);
    });
});
