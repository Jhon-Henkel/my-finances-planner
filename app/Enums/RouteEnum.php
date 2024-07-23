<?php

namespace App\Enums;

enum RouteEnum: string
{
    case ApiWalletIndex = 'apiWalletIndex';
    case ApiWalletInsert = 'apiWalletInsert';
    case ApiWalletUpdate = 'apiWalletUpdate';
    case ApiWalletDelete = 'apiWalletDelete';
    case ApiMovementIndex = 'apiMovementIndex';
    case ApiMovementIndexFiltered = 'apiMovementIndexFiltered';
    case ApiMovementInsert = 'apiMovementInsert';
    case ApiMovementUpdate = 'apiMovementUpdate';
    case ApiMovementDelete = 'apiMovementDelete';
    case ApiMovementInsertTransfer = 'apiMovementInsertTransfer';
    case ApiMovementDeleteTransfer = 'apiMovementDeleteTransfer';
    case ApiCreditCardIndex = 'apiCreditCardIndex';
    case ApiCreditCardInsert = 'apiCreditCardInsert';
    case ApiCreditCardUpdate = 'apiCreditCardUpdate';
    case ApiCreditCardDelete = 'apiCreditCardDelete';
    case ApiCreditCardTransactionShow = 'apiCreditCardTransactionShow';
    case ApiCreditCardTransactionInsert = 'apiCreditCardTransactionInsert';
    case ApiCreditCardTransactionUpdate = 'apiCreditCardTransactionUpdate';
    case ApiCreditCardTransactionDelete = 'apiCreditCardTransactionDelete';
    case ApiCreditCardInvoices = 'apiCreditCardInvoices';
    case ApiCreditCardPayInvoice = 'apiCreditCardPayInvoice';
    case ApiFutureGainNextSixMonths = 'apiFutureGainNextSixMonths';
    case ApiFutureGainShow = 'apiFutureGainShow';
    case ApiFutureGainInsert = 'apiFutureGainInsert';
    case ApiFutureGainUpdate = 'apiFutureGainUpdate';
    case ApiFutureGainDelete = 'apiFutureGainDelete';
    case ApiFutureGainReceive = 'apiFutureGainReceive';
    case ApiFutureSpentShow = 'apiFutureSpentShow';
    case ApiFutureSpentInsert = 'apiFutureSpentInsert';
    case ApiFutureSpentUpdate = 'apiFutureSpentUpdate';
    case ApiFutureSpentDelete = 'apiFutureSpentDelete';
    case ApiFutureSpentPay = 'apiFutureSpentPay';
    case ApiConfigurationGet = 'apiConfigurationGet';
    case ApiConfigurationUpdate = 'apiConfigurationUpdate';
    case ApiUserShow = 'apiUserShow';
    case ApiUserUpdate = 'apiUserUpdate';
    case ApiPanoramaIndex = 'apiPanoramaIndex';
    case ApiFinancialHealthIndexFiltered = 'apiFinancialHealthIndex';
    case WebLogout = 'logout';
    case WebMakeLogin = 'makeLogin';
    case WebVerifyToken = 'verifyToken';
    case WebSendTestEmail = 'sendTestEmail';
    case WebActiveUser = 'activeUser';
    case DevelopGetTokens = 'developGetTokens';
}
