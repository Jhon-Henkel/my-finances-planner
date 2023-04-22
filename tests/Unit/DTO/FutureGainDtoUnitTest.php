<?php

namespace Tests\Unit\DTO;

use App\DTO\FutureGainDTO;
use Tests\TestCase;

class FutureGainDtoUnitTest extends TestCase
{
    public function testFutureGainDto()
    {
        $item = new FutureGainDTO();
        $item->setId(1);
        $item->setWalletId(1);
        $item->setDescription('description');
        $item->setForecast('2021-01-01');
        $item->setAmount(100);
        $item->setInstallments(1);
        $item->setCreatedAt('2021-01-01');
        $item->setUpdatedAt('2021-01-01');

        $this->assertEquals(1, $item->getId());
        $this->assertEquals(1, $item->getWalletId());
        $this->assertEquals('description', $item->getDescription());
        $this->assertEquals('2021-01-01', $item->getForecast());
        $this->assertEquals(100, $item->getAmount());
        $this->assertEquals(1, $item->getInstallments());
        $this->assertEquals('2021-01-01', $item->getCreatedAt());
        $this->assertEquals('2021-01-01', $item->getUpdatedAt());
    }
}