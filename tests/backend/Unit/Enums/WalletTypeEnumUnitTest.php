<?php

namespace Tests\backend\Unit\Enums;

use App\Enums\WalletTypeEnum;
use Tests\backend\Falcon9;

class WalletTypeEnumUnitTest extends Falcon9
{
    public function testEnumValues()
    {
        $this->assertEquals(5, WalletTypeEnum::Money->value);
        $this->assertEquals(6, WalletTypeEnum::BankCount->value);
        $this->assertEquals(8, WalletTypeEnum::MealTicket->value);
        $this->assertEquals(9, WalletTypeEnum::TransportTicket->value);
        $this->assertEquals(10, WalletTypeEnum::HealthInsurance->value);
        $this->assertEquals(0, WalletTypeEnum::Other->value);
    }
}
