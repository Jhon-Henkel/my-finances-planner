<?php

namespace Tests\Unit\Enum;

use App\Enums\InvoiceEnum;
use Tests\TestCase;

class InvoiceEnumUnitTest extends TestCase
{
    public function testEnum()
    {
        $this->assertEquals(6, InvoiceEnum::MAX_INSTALLMENTS);
        $this->assertEquals(0, InvoiceEnum::FIXED_INSTALLMENTS);
    }
}
