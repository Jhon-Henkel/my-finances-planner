<?php

namespace Tests\backend\Unit\Enums;

use App\Enums\InvoiceInstallmentsEnum;
use Tests\backend\Falcon9;

class InvoiceInstallmentsEnumUnitTest extends Falcon9
{
    public function testEnumValues()
    {
        $this->assertEquals(6, InvoiceInstallmentsEnum::MaxInstallments->value);
        $this->assertEquals(0, InvoiceInstallmentsEnum::FixedInstallments->value);
    }
}