<?php

use App\Enums\RouteEnum;
use App\Http\Controllers\ConfigurationsController;
use App\Http\Controllers\CreditCardController;
use App\Http\Controllers\CreditCardTransactionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FinancialHealthController;
use App\Http\Controllers\FutureGainController;
use App\Http\Controllers\FutureSpentController;
use App\Http\Controllers\MonthlyClosingController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\PanoramaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

/** @var Route $router */
$router->prefix('/')->middleware('auth.api:api')->group(function ($router) {
    $router->prefix('dashboard')->group(function () use ($router) {
        $router->get('', [DashboardController::class, 'index'])->name(RouteEnum::API_DASHBOARD_INDEX);
    });
    $router->prefix('wallet')->group(function () use ($router) {
        $router->get('', [WalletController::class, 'index'])->name(RouteEnum::API_WALLET_INDEX);
        $router->get('/{id}', [WalletController::class, 'show'])->name(RouteEnum::API_WALLET_SHOW);
        $router->post('', [WalletController::class, 'insert'])->name(RouteEnum::API_WALLET_INSERT);
        $router->put('/{id}', [WalletController::class, 'update'])->name(RouteEnum::API_WALLET_UPDATE);
        $router->delete('/{id}', [WalletController::class, 'delete'])->name(RouteEnum::API_WALLET_DELETE);
    });
    $router->prefix('movement')->group(function () use ($router) {
        $router->prefix('transfer')->group(function () use ($router) {
            $router->post('', [MovementController::class, 'insertTransfer'])->name(RouteEnum::API_MOVEMENT_INSERT_TRANSFER);
            $router->delete('/{id}', [MovementController::class, 'deleteTransfer'])->name(RouteEnum::API_MOVEMENT_DELETE_TRANSFER);
        });
        $router->get('', [MovementController::class, 'index'])->name(RouteEnum::API_MOVEMENT_INDEX);
        $router->get('/filter', [MovementController::class, 'indexFiltered'])->name(RouteEnum::API_MOVEMENT_INDEX_FILTERED);
        $router->get('/{id}', [MovementController::class, 'show'])->name(RouteEnum::API_MOVEMENT_SHOW);
        $router->post('', [MovementController::class, 'insert'])->name(RouteEnum::API_MOVEMENT_INSERT);
        $router->put('/{id}', [MovementController::class, 'update'])->name(RouteEnum::API_MOVEMENT_UPDATE);
        $router->delete('/{id}', [MovementController::class, 'delete'])->name(RouteEnum::API_MOVEMENT_DELETE);
    });
    $router->prefix('credit-card')->group(function () use ($router) {
        $router->prefix('transaction')->group(function () use ($router) {
            $router->get('', [CreditCardTransactionController::class, 'index'])->name(RouteEnum::API_CREDIT_CARD_TRANSACTION_INDEX);
            $router->get('/{id}', [CreditCardTransactionController::class, 'show'])->name(RouteEnum::API_CREDIT_CARD_TRANSACTION_SHOW);
            $router->post('', [CreditCardTransactionController::class, 'insert'])->name(RouteEnum::API_CREDIT_CARD_TRANSACTION_INSERT);
            $router->put('/{id}', [CreditCardTransactionController::class, 'update'])->name(RouteEnum::API_CREDIT_CARD_TRANSACTION_UPDATE);
            $router->delete('/{id}', [CreditCardTransactionController::class, 'delete'])->name(RouteEnum::API_CREDIT_CARD_TRANSACTION_DELETE);
        });
        $router->prefix('{id}/invoices')->group(function () use ($router) {
            $router->get('', [CreditCardTransactionController::class, 'invoices'])->name(RouteEnum::API_CREDIT_CARD_INVOICES);
            $router->put('/{walletId}', [CreditCardTransactionController::class, 'payInvoice'])->name(RouteEnum::API_CREDIT_CARD_PAY_INVOICE);
        });
        $router->get('', [CreditCardController::class, 'index'])->name(RouteEnum::API_CREDIT_CARD_INDEX);
        $router->get('/{id}', [CreditCardController::class, 'show'])->name(RouteEnum::API_CREDIT_CARD_SHOW);
        $router->post('', [CreditCardController::class, 'insert'])->name(RouteEnum::API_CREDIT_CARD_INSERT);
        $router->put('/{id}', [CreditCardController::class, 'update'])->name(RouteEnum::API_CREDIT_CARD_UPDATE);
        $router->delete('/{id}', [CreditCardController::class, 'delete'])->name(RouteEnum::API_CREDIT_CARD_DELETE);
    });
    $router->prefix('future-gain')->group(function () use ($router) {
        $router->get('', [FutureGainController::class, 'index'])->name(RouteEnum::API_FUTURE_GAIN_INDEX);
        $router->get('next-six-months', [FutureGainController::class, 'nextSixMonths'])->name(RouteEnum::API_FUTURE_GAIN_NEXT_SIX_MONTHS);
        $router->get('/{id}', [FutureGainController::class, 'show'])->name(RouteEnum::API_FUTURE_GAIN_SHOW);
        $router->post('/{id}/receive', [FutureGainController::class, 'receive'])->name(RouteEnum::API_FUTURE_GAIN_RECEIVE);
        $router->post('', [FutureGainController::class, 'insert'])->name(RouteEnum::API_FUTURE_GAIN_INSERT);
        $router->put('/{id}', [FutureGainController::class, 'update'])->name(RouteEnum::API_FUTURE_GAIN_UPDATE);
        $router->delete('/{id}', [FutureGainController::class, 'delete'])->name(RouteEnum::API_FUTURE_GAIN_DELETE);
    });
    $router->prefix('future-spent')->group(function () use ($router) {
        $router->get('', [FutureSpentController::class, 'index'])->name(RouteEnum::API_FUTURE_SPENT_INDEX);
        $router->get('/{id}', [FutureSpentController::class, 'show'])->name(RouteEnum::API_FUTURE_SPENT_SHOW);
        $router->post('', [FutureSpentController::class, 'insert'])->name(RouteEnum::API_FUTURE_SPENT_INSERT);
        $router->post('/{id}/pay', [FutureSpentController::class, 'paySpent'])->name(RouteEnum::API_FUTURE_SPENT_PAY);
        $router->put('/{id}', [FutureSpentController::class, 'update'])->name(RouteEnum::API_FUTURE_SPENT_UPDATE);
        $router->delete('/{id}', [FutureSpentController::class, 'delete'])->name(RouteEnum::API_FUTURE_SPENT_DELETE);
    });
    $router->prefix('configurations')->group(function () use ($router) {
        $router->get('/{configName}', [ConfigurationsController::class, 'showByName'])->name(RouteEnum::API_CONFIGURATION_GET);
        $router->put('/{configName}', [ConfigurationsController::class, 'updateByName'])->name(RouteEnum::API_CONFIGURATION_UPDATE);
    });
    $router->prefix('user')->group(function () use ($router) {
        $router->get('/{id}', [UserController::class, 'show'])->name(RouteEnum::API_USER_SHOW);
        $router->put('/{id}', [UserController::class, 'update'])->name(RouteEnum::API_USER_UPDATE);
    });
    $router->prefix('panorama')->group(function () use ($router) {
        $router->get('', [PanoramaController::class, 'getPanoramaData'])->name(RouteEnum::API_PANORAMA_INDEX);
    });
    $router->prefix('financial-health')->group(function () use ($router) {
        $router->get('/filter/{filter}', [FinancialHealthController::class, 'indexFiltered'])->name(RouteEnum::API_FINANCIAL_HEALTH_INDEX_FILTERED);
    });
    $router->prefix('monthly-closing')->group(function () use ($router) {
        $router->get('/filter/{filter}', [MonthlyClosingController::class, 'indexFiltered'])->name(RouteEnum::API_MONTHLY_CLOSING_INDEX_FILTERED);
    });
});