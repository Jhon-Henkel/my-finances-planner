<?php

namespace Feature\Modules\EarningPlan\Controller;

use App\Enums\RouteNameEnum;
use App\Models\EarningPlan\EarningPlan;
use App\Models\EarningPlan\EarningPlanInstallment;
use Carbon\Carbon;
use Tests\FeatureTestCase;

class EarningPlanDeleteControllerFeatureTest extends FeatureTestCase
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

    public function testDelete()
    {
        $plan = EarningPlan::create(['name' => 'Plano', 'amount' => 10, 'installments_quantity' => 2]);
        EarningPlanInstallment::create(['earning_plan_id' => $plan->id, 'number' => 1, 'amount' => 10, 'due_date' => Carbon::now()->toDateString()]);

        $this->deleteJson(route(RouteNameEnum::ApiV3EarningPlanDelete, [$plan->id]))->assertNoContent();

        $this->assertDatabaseMissing(EarningPlan::class, ['id' => $plan->id]);
        $this->assertDatabaseMissing(EarningPlanInstallment::class, ['earning_plan_id' => $plan->id]);
    }
}
