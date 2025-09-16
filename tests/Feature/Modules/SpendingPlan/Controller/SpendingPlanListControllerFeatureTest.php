<?php

namespace Feature\Modules\SpendingPlan\Controller;

use App\Enums\RouteNameEnum;
use App\Models\SpendingPlan\SpendingPlan;
use App\Models\SpendingPlan\SpendingPlanInstallment;
use Tests\FeatureTestCase;
use Tests\Trait\WalletTrait;

class SpendingPlanListControllerFeatureTest extends FeatureTestCase
{
    use WalletTrait;

    protected function setUp(): void
    {
        parent::setUp();
        SpendingPlanInstallment::query()->delete();
        SpendingPlan::query()->delete();
    }

    protected function tearDown(): void
    {
        SpendingPlanInstallment::query()->delete();
        SpendingPlan::query()->delete();
        parent::tearDown();
    }

    public function testList()
    {
        SpendingPlan::create(['name' => 'Plano 1', 'amount' => 10, 'installments_quantity' => 1]);
        SpendingPlan::create(['name' => 'Plano 2', 'amount' => 20, 'installments_quantity' => 2]);

        $this->getJson(route(RouteNameEnum::ApiV3SpendingPlanList))
            ->assertOk()
            ->assertJsonStructure([
                'status',
                'current_page',
                'data',
                'total',
            ]);
    }
}
