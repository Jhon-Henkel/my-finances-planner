<?php

namespace Tests\backend\Unit\DTO;

use App\DTO\InvoiceItemDTO;
use Tests\backend\Falcon9;

class InvoiceItemDtoUnitTest extends Falcon9
{
    public function testInvoiceItemDto()
    {
        $dto = new InvoiceItemDTO(1, 10, 'TestCount', 'Test', 15.55, '2020-9', 5);

        $this->assertEquals(1, $dto->getId());
        $this->assertEquals(10, $dto->getCountId());
        $this->assertEquals('Test', $dto->getDescription());
        $this->assertEquals('TestCount', $dto->getCountName());
        $this->assertEquals(15.55, $dto->getValue());
        $this->assertEquals('2020-9', $dto->getNextInstallment());
        $this->assertEquals(5, $dto->getInstallments());
        $this->assertEquals(9, $dto->getNextInstallmentMonth());
    }
}