<?php

namespace Tests\Feature\Modules\MarketPlanner\Controller;

use App\Enums\ConfigEnum;
use App\Enums\RouteNameEnum;
use App\Models\Configurations;
use Tests\FeatureTestCase;

class MarketPlannerShowControllerFeatureTest extends FeatureTestCase
{
    public function testGetMarketPlanner()
    {
        Configurations::factory()->create([
            'name' => ConfigEnum::MarketPlannerValue->value,
            'value' => 1000,
        ]);

        $response = $this->getJson(route(RouteNameEnum::ApiV3MarketPlannerShow))
            ->assertOk()
            ->json();

        $this->assertArrayHasKey('total_limit', $response['data']);
        $this->assertEquals(1000, $response['data']['total_limit']);
    }
}
