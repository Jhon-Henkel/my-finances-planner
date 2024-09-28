<?php

namespace Tests\backend\Unit\Resource\Plan;

use App\DTO\Plan\PlanDTO;
use App\Resources\Plan\PlanResource;
use Tests\backend\Falcon9;

class PlanResourceUnitTest extends Falcon9
{
    public function testArrayToDto()
    {
        $planResource = new PlanResource();
        $plan = [
            'id' => 1,
            'name' => 'Basic',
            'wallet_limit' => 1000,
            'credit_card_limit' => 500
        ];
        $planDTO = $planResource->arrayToDto($plan);

        $this->assertEquals(1, $planDTO->getId());
        $this->assertEquals('Basic', $planDTO->getName());
        $this->assertEquals(1000, $planDTO->getWalletLimit());
        $this->assertEquals(500, $planDTO->getCreditCardLimit());
    }

    public function testDtoToArray()
    {
        $planResource = new PlanResource();
        $planDTO = new PlanDTO(1, 'Basic', 1000, 500);
        $plan = $planResource->dtoToArray($planDTO);

        $this->assertEquals(1, $plan['id']);
        $this->assertEquals('Basic', $plan['name']);
        $this->assertEquals(1000, $plan['wallet_limit']);
        $this->assertEquals(500, $plan['credit_card_limit']);
    }

    public function testDtoToVo()
    {
        $planResource = new PlanResource();
        $planDTO = new PlanDTO(1, 'Basic', 1000, 500);
        $planVO = $planResource->dtoToVo($planDTO);

        $this->assertEquals(1, $planVO->id);
        $this->assertEquals('Basic', $planVO->name);
        $this->assertEquals(1000, $planVO->walletLimit);
        $this->assertEquals(500, $planVO->creditCardLimit);
    }
}
