<?php

namespace Tests\Unit\VO;

use App\VO\CreditCardTransactionVO;
use PHPUnit\Framework\TestCase;

class CreditCardTransactionVoUnitTest extends TestCase
{
    public function testMakeCreditCardTransactionVO()
    {
        $vo = CreditCardTransactionVO::makeCreditCardTransactionVO(
            1,
            'TransactionName',
            10.99,
            2,
            '2022-01-02 00:00:00',
            1,
            '2023-10-03 01:30:00',
            '2023-10-03 01:30:00'
        );

        $this->assertEquals(10.99, $vo->value);
        $this->assertEquals(1, $vo->id);
        $this->assertEquals('TransactionName', $vo->name);
        $this->assertEquals(2, $vo->installments);
        $this->assertEquals('2022-01-02 00:00:00', $vo->firstInstallment);
        $this->assertEquals(1, $vo->creditCardId);
        $this->assertEquals('2023-10-03 01:30:00', $vo->createdAt);
        $this->assertEquals('2023-10-03 01:30:00', $vo->updatedAt);
    }
}