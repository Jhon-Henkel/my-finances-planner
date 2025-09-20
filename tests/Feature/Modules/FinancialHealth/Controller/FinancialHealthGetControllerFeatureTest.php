<?php

namespace Tests\Feature\Modules\FinancialHealth\Controller;

use App\Enums\RouteNameEnum;
use App\Models\Movement\Movement;
use App\Modules\Movement\Enum\MovementTypeEnum;
use Tests\FeatureTestCase;

class FinancialHealthGetControllerFeatureTest extends FeatureTestCase
{
    public function testGetFinancialHealth()
    {
        Movement::factory()->count(3)->create(['type' => MovementTypeEnum::Gain->value, 'amount' => 100]);
        Movement::factory()->count(2)->create(['type' => MovementTypeEnum::Spent->value, 'amount' => 50]);

        $response = $this->getJson(route(RouteNameEnum::ApiV3FinancialHealthGet))
            ->assertOk()
            ->json();

        $this->assertArrayHasKey('dataForGraph', $response);
        $this->assertArrayHasKey(MovementTypeEnum::Gain->value, $response['dataForGraph']);
        $this->assertArrayHasKey(MovementTypeEnum::Spent->value, $response['dataForGraph']);
        $this->assertEquals(300, $response['dataForGraph'][MovementTypeEnum::Gain->value]['total']);
        $this->assertEquals(100, $response['dataForGraph'][MovementTypeEnum::Spent->value]['total']);
    }
}
