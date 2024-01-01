<?php

namespace Tests\backend\Unit\Enum;

use App\Enums\InvoiceEnum;
use Tests\backend\Falcon9;

class InvoiceEnumUnitTest extends Falcon9
{
    public function testEnum()
    {
        $this->assertEquals(6, InvoiceEnum::MAX_INSTALLMENTS);
        $this->assertEquals(0, InvoiceEnum::FIXED_INSTALLMENTS);
    }
}
