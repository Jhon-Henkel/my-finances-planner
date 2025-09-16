<?php

namespace Feature\Modules\EarningPlan\Controller;

use App\Enums\RouteNameEnum;
use App\Models\EarningPlan\EarningPlan;
use App\Models\EarningPlan\EarningPlanInstallment;
use Carbon\Carbon;
use Tests\FeatureTestCase;

class EarningPlanUpdateControllerFeatureTest extends FeatureTestCase
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

    private function seedPlan(): EarningPlan
    {
        $plan = EarningPlan::create(['name' => 'Plano', 'amount' => 10, 'installments_quantity' => 2]);
        EarningPlanInstallment::create(['earning_plan_id' => $plan->id, 'number' => 1, 'amount' => 10, 'due_date' => Carbon::now()->toDateString(), 'is_received' => false]);
        EarningPlanInstallment::create(['earning_plan_id' => $plan->id, 'number' => 2, 'amount' => 10, 'due_date' => Carbon::now()->addMonth()->toDateString(), 'is_received' => false]);
        return $plan;
    }

    public function testIncreaseInstallmentsAddsAtEnd()
    {
        $plan = $this->seedPlan();

        $this->putJson(route(RouteNameEnum::ApiV3EarningPlanUpdate, [$plan->id]), [
            'installments' => 4,
            'amount' => 10,
        ])->assertOk();

        $this->assertEquals(4, $plan->installments()->count());
        $this->assertDatabaseHas(EarningPlanInstallment::class, ['earning_plan_id' => $plan->id, 'number' => 3]);
        $this->assertDatabaseHas(EarningPlanInstallment::class, ['earning_plan_id' => $plan->id, 'number' => 4]);
    }

    public function testDecreaseInstallmentsRemovesFromEnd()
    {
        $plan = $this->seedPlan();

        $this->putJson(route(RouteNameEnum::ApiV3EarningPlanUpdate, [$plan->id]), [
            'installments' => 1,
        ])->assertOk();

        $this->assertEquals(1, $plan->installments()->count());
        $this->assertDatabaseMissing(EarningPlanInstallment::class, ['earning_plan_id' => $plan->id, 'number' => 2]);
    }

    public function testScopedInstallmentUpdateSingle()
    {
        $plan = $this->seedPlan();

        $this->putJson(route(RouteNameEnum::ApiV3EarningPlanUpdate, [$plan->id]), [
            'installmentUpdate' => [
                'installmentNumber' => 2,
                'applyToNext' => false,
                'isReceived' => true,
            ]
        ])->assertOk();

        $this->assertDatabaseHas(EarningPlanInstallment::class, [
            'earning_plan_id' => $plan->id,
            'number' => 2,
            'is_received' => true,
        ]);

        $this->assertDatabaseHas(EarningPlanInstallment::class, [
            'earning_plan_id' => $plan->id,
            'number' => 1,
            'is_received' => false,
        ]);
    }

    public function testScopedInstallmentUpdateApplyToNext()
    {
        $plan = $this->seedPlan();

        $this->putJson(route(RouteNameEnum::ApiV3EarningPlanUpdate, [$plan->id]), [
            'installmentUpdate' => [
                'installmentNumber' => 1,
                'applyToNext' => true,
                'amount' => 15,
            ]
        ])->assertOk();

        $this->assertDatabaseHas(EarningPlanInstallment::class, [
            'earning_plan_id' => $plan->id,
            'number' => 1,
            'amount' => 15,
        ]);

        $this->assertDatabaseHas(EarningPlanInstallment::class, [
            'earning_plan_id' => $plan->id,
            'number' => 2,
            'amount' => 15,
        ]);
    }
}
