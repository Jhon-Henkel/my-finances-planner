<?php

namespace Tests\Unit\Enum;

use App\Enums\WalletEnum;
use Tests\TestCase;

class WalletEnumUnitTest extends TestCase
{
    public function testEnumValues()
    {
        $this->assertEquals(5, WalletEnum::MONEY_TYPE);
        $this->assertEquals(6, WalletEnum::BANK_COUNT_TYPE);
        $this->assertEquals(8, WalletEnum::MEAL_TICKET_TYPE);
        $this->assertEquals(9, WalletEnum::TRANSPORT_TICKET_TYPE);
        $this->assertEquals(10, WalletEnum::HEALTH_INSURANCE_TYPE);
        $this->assertEquals(0, WalletEnum::OTHER_TYPE);
    }
}