<?php

namespace App\Enums;

enum RouteEnum: string
{
    case ApiWalletIndex = 'apiWalletIndex';
    case ApiWalletShow = 'apiWalletShow';
    case ApiWalletInsert = 'apiWalletInsert';
    case ApiWalletUpdate = 'apiWalletUpdate';
    case ApiWalletDelete = 'apiWalletDelete';
    case ApiMovementIndex = 'apiMovementIndex';
    case ApiMovementIndexFiltered = 'apiMovementIndexFiltered';
    case ApiMovementDeleteTransfer = 'apiMovementDeleteTransfer';
    case ApiCreditCardIndex = 'apiCreditCardIndex';
    case ApiCreditCardInsert = 'apiCreditCardInsert';
    case ApiCreditCardUpdate = 'apiCreditCardUpdate';
    case ApiCreditCardDelete = 'apiCreditCardDelete';
    case ApiCreditCardTransactionShow = 'apiCreditCardTransactionShow';
    case ApiCreditCardTransactionInsert = 'apiCreditCardTransactionInsert';
    case ApiCreditCardTransactionUpdate = 'apiCreditCardTransactionUpdate';
    case ApiCreditCardTransactionDelete = 'apiCreditCardTransactionDelete';
    case ApiCreditCardPayInvoice = 'apiCreditCardPayInvoice';
    case ApiFutureGainShow = 'apiFutureGainShow';
    case ApiFutureGainInsert = 'apiFutureGainInsert';
    case ApiFutureGainUpdate = 'apiFutureGainUpdate';
    case ApiFutureGainDelete = 'apiFutureGainDelete';
    case ApiFutureGainReceive = 'apiFutureGainReceive';
    case ApiFutureSpentDelete = 'apiFutureSpentDelete';
    case ApiFutureSpentPay = 'apiFutureSpentPay';
    case ApiConfigurationUpdate = 'apiConfigurationUpdate';
    case ApiConfigurationIndex = 'apiConfigurationIndex';
    case ApiUserShow = 'apiUserShow';
    case ApiUserUpdate = 'apiUserUpdate';
    case ApiFinancialHealthIndexFiltered = 'apiFinancialHealthIndex';
    case ApiSubscribe = 'apiSubscribe';
    case ApiCancelSubscribe = 'apiCancelSubscribe';
    case ApiSubscribeUpdateAccount = 'apiSubscribeUpdateAccount';
    case ApiSubscribePaymentComplete = 'apiSubscribePaymentComplete';
    case ApiPlanIndex = 'apiPlanIndex';
    case ApiUserRegisterStepZero = 'apiUserRegisterStepZero';
    case ApiMakeLogin = 'apiMakeLogin';
    case ApiLogout = 'apiLogout';
    case WebActiveUser = 'webActiveUser';
    case WebSendTestEmail = 'sendTestEmail';
    case WebTestViewEmail = 'testViewEmail';
    case WebMakeLogin = 'login';
    case DevelopGetTokens = 'developGetTokens';
    case MfpUserRegisterStepOne = 'userRegisterStepOne';
    case MfpUserRegisterStepTwo = 'userRegisterStepTwo';
    case MfpUserRegisterStepThree = 'userRegisterStepThree';

    //////////// API V2 ////////////
    case ApiSpendingPlanList = 'spending-plan.list';
    case ApiSpendingPlanInsert = 'spending-plan.insert';
    case ApiSpendingPlanUpdate = 'spending-plan.update';
    case ApiSpendingPlanGet = 'spending-plan.get';

    case ApiEarningPlanList = 'earning-plan.list';

    case ApiMarketPlannerShow = 'market-planner.show';

    case ApiCreditCardInvoiceList = 'credit-card-invoice.list';

    case ApiMovementInsert = 'movement.insert';
    case ApiMovementUpdate = 'movement.update';
    case ApiMovementDelete = 'movement.delete';
    case ApiMovementInsertTransfer = 'movement.transfer.insert';

    //////////// API MARKET CONTROL ////////////]
    case ApiMarketControlWalletList = 'market-control.wallet.list';
    case ApiMarketControlMarkSpent = 'market-control.mark-spent';
}
