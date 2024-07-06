<?php

namespace Tests\backend\Unit\VO;

use App\DTO\FutureMovement\FutureGainDTO;
use App\VO\FutureGainVO;
use PHPUnit\Framework\TestCase;

class FutureGainVoUnitTest extends TestCase
{
    public function testFutureGainVo()
    {
        $item = new FutureGainDTO();
        $item->setId(1);
        $item->setWalletId(1);
        $item->setDescription('Teste');
        $item->setWalletName('TestCountName');
        $item->setAmount(100);
        $item->setInstallments(1);
        $item->setForecast('2022-01-01');
        $item->setCreatedAt('2021-07-15');
        $item->setUpdatedAt('2022-03-28');

        $vo = new FutureGainVO($item);

        $this->assertEquals(1, $vo->id);
        $this->assertEquals(1, $vo->walletId);
        $this->assertEquals('Teste', $vo->description);
        $this->assertEquals('TestCountName', $vo->walletName);
        $this->assertEquals(100, $vo->amount);
        $this->assertEquals(1, $vo->installments);
        $this->assertEquals('2022-01-01', $vo->forecast);
        $this->assertEquals('2021-07-15', $vo->createdAt);
        $this->assertEquals('2022-03-28', $vo->updatedAt);
    }
}
