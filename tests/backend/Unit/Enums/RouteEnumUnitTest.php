<?php

namespace Tests\backend\Unit\Enums;

use App\Enums\RouteNameEnum;
use Tests\backend\Falcon9;

class RouteEnumUnitTest extends Falcon9
{
    public function testEnumValues()
    {
        $this->assertEquals('apiWalletIndex', RouteNameEnum::ApiWalletIndex->value);
        $this->assertEquals('apiWalletInsert', RouteNameEnum::ApiWalletInsert->value);
        $this->assertEquals('apiWalletUpdate', RouteNameEnum::ApiWalletUpdate->value);
        $this->assertEquals('apiWalletDelete', RouteNameEnum::ApiWalletDelete->value);
        $this->assertEquals('apiCreditCardIndex', RouteNameEnum::ApiCreditCardIndex->value);
        $this->assertEquals('apiCreditCardInsert', RouteNameEnum::ApiCreditCardInsert->value);
        $this->assertEquals('apiCreditCardUpdate', RouteNameEnum::ApiCreditCardUpdate->value);
        $this->assertEquals('apiCreditCardDelete', RouteNameEnum::ApiCreditCardDelete->value);
        $this->assertEquals('apiCreditCardTransactionShow', RouteNameEnum::ApiCreditCardTransactionShow->value);
        $this->assertEquals('apiCreditCardTransactionInsert', RouteNameEnum::ApiCreditCardTransactionInsert->value);
        $this->assertEquals('apiCreditCardTransactionUpdate', RouteNameEnum::ApiCreditCardTransactionUpdate->value);
        $this->assertEquals('apiCreditCardTransactionDelete', RouteNameEnum::ApiCreditCardTransactionDelete->value);
        $this->assertEquals('apiCreditCardPayInvoice', RouteNameEnum::ApiCreditCardPayInvoice->value);
        $this->assertEquals('apiFutureGainShow', RouteNameEnum::ApiFutureGainShow->value);
        $this->assertEquals('apiFutureGainInsert', RouteNameEnum::ApiFutureGainInsert->value);
        $this->assertEquals('apiFutureGainUpdate', RouteNameEnum::ApiFutureGainUpdate->value);
        $this->assertEquals('apiFutureGainDelete', RouteNameEnum::ApiFutureGainDelete->value);
        $this->assertEquals('apiFutureGainReceive', RouteNameEnum::ApiFutureGainReceive->value);
        $this->assertEquals('apiFutureSpentDelete', RouteNameEnum::ApiFutureSpentDelete->value);
        $this->assertEquals('apiFutureSpentPay', RouteNameEnum::ApiFutureSpentPay->value);
        $this->assertEquals('apiConfigurationUpdate', RouteNameEnum::ApiConfigurationUpdate->value);
        $this->assertEquals('apiUserShow', RouteNameEnum::ApiUserShow->value);
        $this->assertEquals('apiUserUpdate', RouteNameEnum::ApiUserUpdate->value);
        $this->assertEquals('apiFinancialHealthIndex', RouteNameEnum::ApiFinancialHealthIndexFiltered->value);
        $this->assertEquals('sendTestEmail', RouteNameEnum::WebSendTestEmail->value);
        $this->assertEquals('developGetTokens', RouteNameEnum::DevelopGetTokens->value);
        $this->assertEquals('spending-plan.list', RouteNameEnum::ApiSpendingPlanList->value);
    }
}
