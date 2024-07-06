<?php

namespace Tests\backend\Unit\Enums;

use App\Enums\RouteEnum;
use Tests\backend\Falcon9;

class RouteEnumUnitTest extends Falcon9
{
    public function testEnumValues()
    {
        $this->assertEquals('apiDashboardIndex', RouteEnum::ApiDashboardIndex->value);
        $this->assertEquals('apiWalletIndex', RouteEnum::ApiWalletIndex->value);
        $this->assertEquals('apiWalletShow', RouteEnum::ApiWalletShow->value);
        $this->assertEquals('apiWalletInsert', RouteEnum::ApiWalletInsert->value);
        $this->assertEquals('apiWalletUpdate', RouteEnum::ApiWalletUpdate->value);
        $this->assertEquals('apiWalletDelete', RouteEnum::ApiWalletDelete->value);
        $this->assertEquals('apiMovementIndex', RouteEnum::ApiMovementIndex->value);
        $this->assertEquals('apiMovementIndexFiltered', RouteEnum::ApiMovementIndexFiltered->value);
        $this->assertEquals('apiMovementShow', RouteEnum::ApiMovementShow->value);
        $this->assertEquals('apiMovementInsert', RouteEnum::ApiMovementInsert->value);
        $this->assertEquals('apiMovementUpdate', RouteEnum::ApiMovementUpdate->value);
        $this->assertEquals('apiMovementDelete', RouteEnum::ApiMovementDelete->value);
        $this->assertEquals('apiMovementInsertTransfer', RouteEnum::ApiMovementInsertTransfer->value);
        $this->assertEquals('apiMovementDeleteTransfer', RouteEnum::ApiMovementDeleteTransfer->value);
        $this->assertEquals('apiCreditCardIndex', RouteEnum::ApiCreditCardIndex->value);
        $this->assertEquals('apiCreditCardShow', RouteEnum::ApiCreditCardShow->value);
        $this->assertEquals('apiCreditCardInsert', RouteEnum::ApiCreditCardInsert->value);
        $this->assertEquals('apiCreditCardUpdate', RouteEnum::ApiCreditCardUpdate->value);
        $this->assertEquals('apiCreditCardDelete', RouteEnum::ApiCreditCardDelete->value);
        $this->assertEquals('apiCreditCardTransactionIndex', RouteEnum::ApiCreditCardTransactionIndex->value);
        $this->assertEquals('apiCreditCardTransactionShow', RouteEnum::ApiCreditCardTransactionShow->value);
        $this->assertEquals('apiCreditCardTransactionInsert', RouteEnum::ApiCreditCardTransactionInsert->value);
        $this->assertEquals('apiCreditCardTransactionUpdate', RouteEnum::ApiCreditCardTransactionUpdate->value);
        $this->assertEquals('apiCreditCardTransactionDelete', RouteEnum::ApiCreditCardTransactionDelete->value);
        $this->assertEquals('apiCreditCardInvoices', RouteEnum::ApiCreditCardInvoices->value);
        $this->assertEquals('apiCreditCardPayInvoice', RouteEnum::ApiCreditCardPayInvoice->value);
        $this->assertEquals('apiFutureGainIndex', RouteEnum::ApiFutureGainIndex->value);
        $this->assertEquals('apiFutureGainNextSixMonths', RouteEnum::ApiFutureGainNextSixMonths->value);
        $this->assertEquals('apiFutureGainShow', RouteEnum::ApiFutureGainShow->value);
        $this->assertEquals('apiFutureGainInsert', RouteEnum::ApiFutureGainInsert->value);
        $this->assertEquals('apiFutureGainUpdate', RouteEnum::ApiFutureGainUpdate->value);
        $this->assertEquals('apiFutureGainDelete', RouteEnum::ApiFutureGainDelete->value);
        $this->assertEquals('apiFutureGainReceive', RouteEnum::ApiFutureGainReceive->value);
        $this->assertEquals('apiFutureSpentIndex', RouteEnum::ApiFutureSpentIndex->value);
        $this->assertEquals('apiFutureSpentShow', RouteEnum::ApiFutureSpentShow->value);
        $this->assertEquals('apiFutureSpentInsert', RouteEnum::ApiFutureSpentInsert->value);
        $this->assertEquals('apiFutureSpentUpdate', RouteEnum::ApiFutureSpentUpdate->value);
        $this->assertEquals('apiFutureSpentDelete', RouteEnum::ApiFutureSpentDelete->value);
        $this->assertEquals('apiFutureSpentPay', RouteEnum::ApiFutureSpentPay->value);
        $this->assertEquals('apiConfigurationGet', RouteEnum::ApiConfigurationGet->value);
        $this->assertEquals('apiConfigurationUpdate', RouteEnum::ApiConfigurationUpdate->value);
        $this->assertEquals('apiUserShow', RouteEnum::ApiUserShow->value);
        $this->assertEquals('apiUserUpdate', RouteEnum::ApiUserUpdate->value);
        $this->assertEquals('apiPanoramaIndex', RouteEnum::ApiPanoramaIndex->value);
        $this->assertEquals('apiFinancialHealthIndex', RouteEnum::ApiFinancialHealthIndexFiltered->value);
        $this->assertEquals('apiMonthlyClosingIndexFiltered', RouteEnum::ApiMonthlyClosingIndexFiltered->value);
        $this->assertEquals('apiInvestmentIndex', RouteEnum::ApiInvestmentIndex->value);
        $this->assertEquals('apiInvestmentShow', RouteEnum::ApiInvestmentShow->value);
        $this->assertEquals('apiInvestmentInsert', RouteEnum::ApiInvestmentInsert->value);
        $this->assertEquals('apiInvestmentUpdate', RouteEnum::ApiInvestmentUpdate->value);
        $this->assertEquals('apiInvestmentDelete', RouteEnum::ApiInvestmentDelete->value);
        $this->assertEquals('apiInvestmentCdbDataGraph', RouteEnum::ApiInvestmentCdbDataGraph->value);
        $this->assertEquals('apiInvestmentRescueApport', RouteEnum::ApiInvestmentRescueApport->value);
        $this->assertEquals('logout', RouteEnum::WebLogout->value);
        $this->assertEquals('makeLogin', RouteEnum::WebMakeLogin->value);
        $this->assertEquals('verifyToken', RouteEnum::WebVerifyToken->value);
        $this->assertEquals('sendTestEmail', RouteEnum::WebSendTestEmail->value);
        $this->assertEquals('activeUser', RouteEnum::WebActiveUser->value);
        $this->assertEquals('developGetTokens', RouteEnum::DevelopGetTokens->value);
    }
}
