<?php

use App\Enums\RouteEnum;
use App\Http\Controllers\ConfigurationsController;
use App\Http\Controllers\CreditCardController;
use App\Http\Controllers\CreditCardTransactionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FinancialHealthController;
use App\Http\Controllers\FutureGainController;
use App\Http\Controllers\FutureSpentController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\PanoramaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

/** @var Route $router */
$router->prefix('/')->middleware('auth.api:api')->group(function ($router) {
    $router->prefix('dashboard')->group(function () use ($router) {
        $router->get('', [DashboardController::class, 'index'])->name(RouteEnum::ApiDashboardIndex->value);
    });

    $router->prefix('wallet')->group(function () use ($router) {
        $router->get('', [WalletController::class, 'index'])->name(RouteEnum::ApiWalletIndex->value);
        $router->get('/{id}', [WalletController::class, 'show'])->name(RouteEnum::ApiWalletShow->value);
        $router->post('', [WalletController::class, 'insert'])->name(RouteEnum::ApiWalletInsert->value);
        $router->put('/{id}', [WalletController::class, 'update'])->name(RouteEnum::ApiWalletUpdate->value);
        $router->delete('/{id}', [WalletController::class, 'delete'])->name(RouteEnum::ApiWalletDelete->value);
    });

    $router->prefix('movement')->group(function () use ($router) {
        $router->prefix('transfer')->group(function () use ($router) {
            $router->post('', [MovementController::class, 'insertTransfer'])->name(RouteEnum::ApiMovementInsertTransfer->value);
            $router->delete('/{id}', [MovementController::class, 'deleteTransfer'])->name(RouteEnum::ApiMovementDeleteTransfer->value);
        });

        $router->get('', [MovementController::class, 'index'])->name(RouteEnum::ApiMovementIndex->value);
        $router->get('/filter', [MovementController::class, 'indexFiltered'])->name(RouteEnum::ApiMovementIndexFiltered->value);
        $router->get('/{id}', [MovementController::class, 'show'])->name(RouteEnum::ApiMovementShow->value);
        $router->post('', [MovementController::class, 'insert'])->name(RouteEnum::ApiMovementInsert->value);
        $router->put('/{id}', [MovementController::class, 'update'])->name(RouteEnum::ApiMovementUpdate->value);
        $router->delete('/{id}', [MovementController::class, 'delete'])->name(RouteEnum::ApiMovementDelete->value);
    });

    $router->prefix('credit-card')->group(function () use ($router) {
        $router->prefix('transaction')->group(function () use ($router) {
            $router->get('', [CreditCardTransactionController::class, 'index'])->name(RouteEnum::ApiCreditCardTransactionIndex->value);
            $router->get('/{id}', [CreditCardTransactionController::class, 'show'])->name(RouteEnum::ApiCreditCardTransactionShow->value);
            $router->post('', [CreditCardTransactionController::class, 'insert'])->name(RouteEnum::ApiCreditCardTransactionInsert->value);
            $router->put('/{id}', [CreditCardTransactionController::class, 'update'])->name(RouteEnum::ApiCreditCardTransactionUpdate->value);
            $router->delete('/{id}', [CreditCardTransactionController::class, 'delete'])->name(RouteEnum::ApiCreditCardTransactionDelete->value);
        });

        $router->prefix('{id}/invoices')->group(function () use ($router) {
            $router->get('', [CreditCardTransactionController::class, 'invoices'])->name(RouteEnum::ApiCreditCardInvoices->value);
            $router->put('/{walletId}', [CreditCardTransactionController::class, 'payInvoice'])->name(RouteEnum::ApiCreditCardPayInvoice->value);
        });

        $router->get('', [CreditCardController::class, 'index'])->name(RouteEnum::ApiCreditCardIndex->value);
        $router->get('/{id}', [CreditCardController::class, 'show'])->name(RouteEnum::ApiCreditCardShow->value);
        $router->post('', [CreditCardController::class, 'insert'])->name(RouteEnum::ApiCreditCardInsert->value);
        $router->put('/{id}', [CreditCardController::class, 'update'])->name(RouteEnum::ApiCreditCardUpdate->value);
        $router->delete('/{id}', [CreditCardController::class, 'delete'])->name(RouteEnum::ApiCreditCardDelete->value);
    });

    $router->prefix('future-gain')->group(function () use ($router) {
        $router->get('', [FutureGainController::class, 'index'])->name(RouteEnum::ApiFutureGainIndex->value);
        $router->get('next-six-months', [FutureGainController::class, 'nextSixMonths'])->name(RouteEnum::ApiFutureGainNextSixMonths->value);
        $router->get('/{id}', [FutureGainController::class, 'show'])->name(RouteEnum::ApiFutureGainShow->value);
        $router->post('/{id}/receive', [FutureGainController::class, 'receive'])->name(RouteEnum::ApiFutureGainReceive->value);
        $router->post('', [FutureGainController::class, 'insert'])->name(RouteEnum::ApiFutureGainInsert->value);
        $router->put('/{id}', [FutureGainController::class, 'update'])->name(RouteEnum::ApiFutureGainUpdate->value);
        $router->delete('/{id}', [FutureGainController::class, 'delete'])->name(RouteEnum::ApiFutureGainDelete->value);
    });

    $router->prefix('future-spent')->group(function () use ($router) {
        $router->get('', [FutureSpentController::class, 'index'])->name(RouteEnum::ApiFutureSpentIndex->value);
        $router->get('/{id}', [FutureSpentController::class, 'show'])->name(RouteEnum::ApiFutureSpentShow->value);
        $router->post('', [FutureSpentController::class, 'insert'])->name(RouteEnum::ApiFutureSpentInsert->value);
        $router->post('/{id}/pay', [FutureSpentController::class, 'paySpent'])->name(RouteEnum::ApiFutureSpentPay->value);
        $router->put('/{id}', [FutureSpentController::class, 'update'])->name(RouteEnum::ApiFutureSpentUpdate->value);
        $router->delete('/{id}', [FutureSpentController::class, 'delete'])->name(RouteEnum::ApiFutureSpentDelete->value);
    });

    $router->prefix('configurations')->group(function () use ($router) {
        $router->get('/{configName}', [ConfigurationsController::class, 'showByName'])->name(RouteEnum::ApiConfigurationGet->value);
        $router->put('/{configName}', [ConfigurationsController::class, 'updateByName'])->name(RouteEnum::ApiConfigurationUpdate->value);
    });

    $router->prefix('user')->group(function () use ($router) {
        $router->get('/{id}', [UserController::class, 'show'])->name(RouteEnum::ApiUserShow->value);
        $router->put('/{id}', [UserController::class, 'update'])->name(RouteEnum::ApiUserUpdate->value);
    });

    $router->prefix('panorama')->group(function () use ($router) {
        $router->get('', [PanoramaController::class, 'getPanoramaData'])->name(RouteEnum::ApiPanoramaIndex->value);
    });

    $router->prefix('financial-health')->group(function () use ($router) {
        $router->get('/filter', [FinancialHealthController::class, 'indexFiltered'])->name(RouteEnum::ApiFinancialHealthIndexFiltered->value);
    });
});
