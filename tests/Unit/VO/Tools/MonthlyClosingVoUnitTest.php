<?php

namespace Tests\Unit\VO\Tools;

use App\VO\Tools\MonthlyClosingVO;
use Tests\Falcon9;

class MonthlyClosingVoUnitTest extends Falcon9
{
    public function testVO()
    {
        $id = 1;
        $predictedEarnings = 100.00;
        $predictedExpenses = 50.00;
        $realEarnings = 100.00;
        $realExpenses = 50.00;
        $balance = 50.00;
        $createdAt = '2021-06-25 15:42:39';
        $updatedAt = '2021-06-25 15:42:39';

        $vo = new MonthlyClosingVO(
            $id,
            $predictedEarnings,
            $predictedExpenses,
            $realEarnings,
            $realExpenses,
            $balance,
            $createdAt,
            $updatedAt
        );

        $this->assertEquals($id, $vo->id);
        $this->assertEquals($predictedEarnings, $vo->predictedEarnings);
        $this->assertEquals($predictedExpenses, $vo->predictedExpenses);
        $this->assertEquals($realEarnings, $vo->realEarnings);
        $this->assertEquals($realExpenses, $vo->realExpenses);
        $this->assertEquals($balance, $vo->balance);
        $this->assertEquals($createdAt, $vo->createdAt);
        $this->assertEquals($updatedAt, $vo->updatedAt);
    }
}