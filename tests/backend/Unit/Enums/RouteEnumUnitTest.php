<?php

namespace Tests\backend\Unit\Enums;

use App\Enums\RouteEnum;
use Tests\backend\Falcon9;

class RouteEnumUnitTest extends Falcon9
{
    public function testEnumValues()
    {
        $this->assertEquals('apiWalletIndex', RouteEnum::ApiWalletIndex->value);
        $this->assertEquals('apiWalletInsert', RouteEnum::ApiWalletInsert->value);
        $this->assertEquals('apiWalletUpdate', RouteEnum::ApiWalletUpdate->value);
        $this->assertEquals('apiWalletDelete', RouteEnum::ApiWalletDelete->value);
        $this->assertEquals('apiMovementIndex', RouteEnum::ApiMovementIndex->value);
        $this->assertEquals('apiMovementIndexFiltered', RouteEnum::ApiMovementIndexFiltered->value);
        $this->assertEquals('apiMovementInsertTransfer', RouteEnum::ApiMovementInsertTransfer->value);
        $this->assertEquals('apiMovementDeleteTransfer', RouteEnum::ApiMovementDeleteTransfer->value);
        $this->assertEquals('apiCreditCardIndex', RouteEnum::ApiCreditCardIndex->value);
        $this->assertEquals('apiCreditCardInsert', RouteEnum::ApiCreditCardInsert->value);
        $this->assertEquals('apiCreditCardUpdate', RouteEnum::ApiCreditCardUpdate->value);
        $this->assertEquals('apiCreditCardDelete', RouteEnum::ApiCreditCardDelete->value);
        $this->assertEquals('apiCreditCardTransactionShow', RouteEnum::ApiCreditCardTransactionShow->value);
        $this->assertEquals('apiCreditCardTransactionInsert', RouteEnum::ApiCreditCardTransactionInsert->value);
        $this->assertEquals('apiCreditCardTransactionUpdate', RouteEnum::ApiCreditCardTransactionUpdate->value);
        $this->assertEquals('apiCreditCardTransactionDelete', RouteEnum::ApiCreditCardTransactionDelete->value);
        $this->assertEquals('apiCreditCardPayInvoice', RouteEnum::ApiCreditCardPayInvoice->value);
        $this->assertEquals('apiFutureGainShow', RouteEnum::ApiFutureGainShow->value);
        $this->assertEquals('apiFutureGainInsert', RouteEnum::ApiFutureGainInsert->value);
        $this->assertEquals('apiFutureGainUpdate', RouteEnum::ApiFutureGainUpdate->value);
        $this->assertEquals('apiFutureGainDelete', RouteEnum::ApiFutureGainDelete->value);
        $this->assertEquals('apiFutureGainReceive', RouteEnum::ApiFutureGainReceive->value);
        $this->assertEquals('apiFutureSpentDelete', RouteEnum::ApiFutureSpentDelete->value);
        $this->assertEquals('apiFutureSpentPay', RouteEnum::ApiFutureSpentPay->value);
        $this->assertEquals('apiConfigurationUpdate', RouteEnum::ApiConfigurationUpdate->value);
        $this->assertEquals('apiUserShow', RouteEnum::ApiUserShow->value);
        $this->assertEquals('apiUserUpdate', RouteEnum::ApiUserUpdate->value);
        $this->assertEquals('apiFinancialHealthIndex', RouteEnum::ApiFinancialHealthIndexFiltered->value);
        $this->assertEquals('sendTestEmail', RouteEnum::WebSendTestEmail->value);
        $this->assertEquals('developGetTokens', RouteEnum::DevelopGetTokens->value);
        $this->assertEquals('spending-plan.list', RouteEnum::ApiSpendingPlanList->value);
    }
}
