<?php

namespace Feature\Modules\SpendingPlan\Controller;

use App\Enums\RouteNameEnum;
use App\Models\SpendingPlan\SpendingPlan;
use App\Models\SpendingPlan\SpendingPlanInstallment;
use Carbon\Carbon;
use Tests\FeatureTestCase;
use Tests\Trait\WalletTrait;

class SpendingPlanDeleteControllerFeatureTest extends FeatureTestCase
{
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

    public function testDelete()
    {
        $plan = SpendingPlan::create(['name' => 'Plano', 'amount' => 10, 'installments_quantity' => 2]);
        SpendingPlanInstallment::create(['spending_plan_id' => $plan->id, 'number' => 1, 'amount' => 10, 'due_date' => Carbon::now()->toDateString()]);

        $this->deleteJson(route(RouteNameEnum::ApiV3SpendingPlanDelete, [$plan->id]))->assertNoContent();

        $this->assertDatabaseMissing(SpendingPlan::class, ['id' => $plan->id]);
        $this->assertDatabaseMissing(SpendingPlanInstallment::class, ['spending_plan_id' => $plan->id]);
    }
}
