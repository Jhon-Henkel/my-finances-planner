<?php

namespace Tests\Unit\DTO;

use App\DTO\InvoiceItemDTO;
use Tests\TestCase;

class InvoiceItemDtoUnitTest extends TestCase
{
    public function testInvoiceItemDto()
    {
        $dto = new InvoiceItemDTO(1, 10, 'Test', 15.55, '2020-9', 5);

        $this->assertEquals(1, $dto->getId());
        $this->assertEquals(10, $dto->getCountId());
        $this->assertEquals('Test', $dto->getDescription());
        $this->assertEquals(15.55, $dto->getValue());
        $this->assertEquals('2020-9', $dto->getNextInstallment());
        $this->assertEquals(5, $dto->getInstallments());
        $this->assertEquals(9, $dto->getNextInstallmentMonth());
    }
}