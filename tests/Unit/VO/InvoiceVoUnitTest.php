<?php

namespace Tests\Unit\VO;

use App\DTO\InvoiceItemDTO;
use App\VO\InvoiceVO;
use Tests\Falcon9;

class InvoiceVoUnitTest extends Falcon9
{
    public function testInvoiceVo()
    {
        $dto = new InvoiceItemDTO(1, 5, 'TestCountName', 'Test', 10.99, '2021-2', 0);
        $instalments = [
            0 => 10.99,
            1 => 10.99,
            2 => null,
            3 => null,
            4 => null,
            5 => null,
        ];
        $vo = InvoiceVO::makeInvoice($dto, $instalments, 21.98);

        $this->assertEquals(1, $vo->id);
        $this->assertEquals(5, $vo->countId);
        $this->assertEquals('Test', $vo->name);
        $this->assertEquals('TestCountName', $vo->countName);
        $this->assertEquals(0, $vo->remainingInstallments);
        $this->assertEquals(10.99, $vo->firstInstallment);
        $this->assertEquals(10.99, $vo->secondInstallment);
        $this->assertEquals(null, $vo->thirdInstallment);
        $this->assertEquals(null, $vo->forthInstallment);
        $this->assertEquals(null, $vo->fifthInstallment);
        $this->assertEquals(null, $vo->sixthInstallment);
        $this->assertEquals(21.98, $vo->totalRemainingValue);
    }
}