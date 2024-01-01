<?php

namespace Tests\backend\Unit\VO\Investment;

use App\DTO\Investment\InvestmentDTO;
use App\VO\Investment\InvestmentVO;
use Tests\backend\Falcon9;

class InvestmentVoUnitTest extends Falcon9
{
    public function testInvestmentVo()
    {
        $dto = new InvestmentDTO(
            1,
            1,
            'Test',
            1,
            1.0,
            1,
            1.0,
            '2021-01-01',
            '2021-01-01'
        );

        $vo = new InvestmentVO($dto);

        $this->assertEquals(1, $vo->id);
        $this->assertEquals(1, $vo->creditCardId);
        $this->assertEquals('Test', $vo->description);
        $this->assertEquals(1, $vo->type);
        $this->assertEquals(1.0, $vo->amount);
        $this->assertEquals(1, $vo->liquidity);
        $this->assertEquals(1.0, $vo->profitability);
        $this->assertEquals('2021-01-01', $vo->createdAt);
        $this->assertEquals('2021-01-01', $vo->updatedAt);
    }
}