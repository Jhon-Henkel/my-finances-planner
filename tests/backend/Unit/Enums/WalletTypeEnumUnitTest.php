<?php

namespace Tests\backend\Unit\Enums;

use App\Modules\Wallet\Enum\WalletTypeEnum;
use Tests\backend\Falcon9;

class WalletTypeEnumUnitTest extends Falcon9
{
    public function testEnumValues()
    {
        $this->assertEquals(0, WalletTypeEnum::Other->value);
    }
}
