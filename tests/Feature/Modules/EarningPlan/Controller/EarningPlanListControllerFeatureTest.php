<?php

namespace Feature\Modules\EarningPlan\Controller;

use App\Enums\RouteNameEnum;
use App\Models\EarningPlan\EarningPlan;
use App\Models\EarningPlan\EarningPlanInstallment;
use Tests\FeatureTestCase;

class EarningPlanListControllerFeatureTest extends FeatureTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        EarningPlanInstallment::query()->delete();
        EarningPlan::query()->delete();
    }

    protected function tearDown(): void
    {
        EarningPlanInstallment::query()->delete();
        EarningPlan::query()->delete();
        parent::tearDown();
    }

    public function testList()
    {
        EarningPlan::create(['name' => 'Plano 1', 'amount' => 10, 'installments_quantity' => 1]);
        EarningPlan::create(['name' => 'Plano 2', 'amount' => 20, 'installments_quantity' => 2]);

        $this->getJson(route(RouteNameEnum::ApiV3EarningPlanList))
            ->assertOk()
            ->assertJsonStructure([
                'status',
                'current_page',
                'data',
                'total',
            ]);
    }
}
