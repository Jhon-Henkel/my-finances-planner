<?php

namespace Feature\Modules\SpendingPlan\Controller;

use App\Enums\RouteNameEnum;
use App\Models\SpendingPlan\SpendingPlan;
use App\Models\SpendingPlan\SpendingPlanInstallment;
use Carbon\Carbon;
use Tests\FeatureTestCase;
use Tests\Trait\WalletTrait;

class SpendingPlanUpdateControllerFeatureTest extends FeatureTestCase
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

    private function seedPlan(): SpendingPlan
    {
        $plan = SpendingPlan::create(['name' => 'Plano', 'amount' => 10, 'installments_quantity' => 2]);
        SpendingPlanInstallment::create(['spending_plan_id' => $plan->id, 'number' => 1, 'amount' => 10, 'due_date' => Carbon::now()->toDateString(), 'is_paid' => false]);
        SpendingPlanInstallment::create(['spending_plan_id' => $plan->id, 'number' => 2, 'amount' => 10, 'due_date' => Carbon::now()->addMonth()->toDateString(), 'is_paid' => false]);
        return $plan;
    }

    public function testIncreaseInstallmentsAddsAtEnd()
    {
        $plan = $this->seedPlan();

        $this->putJson(route(RouteNameEnum::ApiV3SpendingPlanUpdate, [$plan->id]), [
            'installments' => 4,
            'amount' => 10,
        ])->assertOk();

        $this->assertEquals(4, $plan->installments()->count());
        $this->assertDatabaseHas(SpendingPlanInstallment::class, ['spending_plan_id' => $plan->id, 'number' => 3]);
        $this->assertDatabaseHas(SpendingPlanInstallment::class, ['spending_plan_id' => $plan->id, 'number' => 4]);
    }

    public function testDecreaseInstallmentsRemovesFromEnd()
    {
        $plan = $this->seedPlan();

        $this->putJson(route(RouteNameEnum::ApiV3SpendingPlanUpdate, [$plan->id]), [
            'installments' => 1,
        ])->assertOk();

        $this->assertEquals(1, $plan->installments()->count());
        $this->assertDatabaseMissing(SpendingPlanInstallment::class, ['spending_plan_id' => $plan->id, 'number' => 2]);
    }

    public function testScopedInstallmentUpdateSingle()
    {
        $plan = $this->seedPlan();

        $this->putJson(route(RouteNameEnum::ApiV3SpendingPlanUpdate, [$plan->id]), [
            'installmentUpdate' => [
                'installmentNumber' => 2,
                'applyToNext' => false,
                'isPaid' => true,
                'bankSlipCode' => 'ABC'
            ]
        ])->assertOk();

        $this->assertDatabaseHas(SpendingPlanInstallment::class, [
            'spending_plan_id' => $plan->id,
            'number' => 2,
            'is_paid' => true,
            'bank_slip_code' => 'ABC',
        ]);

        $this->assertDatabaseHas(SpendingPlanInstallment::class, [
            'spending_plan_id' => $plan->id,
            'number' => 1,
            'is_paid' => false,
        ]);
    }

    public function testScopedInstallmentUpdateApplyToNext()
    {
        $plan = $this->seedPlan();

        $this->putJson(route(RouteNameEnum::ApiV3SpendingPlanUpdate, [$plan->id]), [
            'installmentUpdate' => [
                'installmentNumber' => 1,
                'applyToNext' => true,
                'amount' => 15,
            ]
        ])->assertOk();

        $this->assertDatabaseHas(SpendingPlanInstallment::class, [
            'spending_plan_id' => $plan->id,
            'number' => 1,
            'amount' => 15,
        ]);

        $this->assertDatabaseHas(SpendingPlanInstallment::class, [
            'spending_plan_id' => $plan->id,
            'number' => 2,
            'amount' => 15,
        ]);
    }
}
