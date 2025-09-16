<?php

namespace Feature\Modules\SpendingPlan\Controller;

use App\Enums\RouteNameEnum;
use App\Models\SpendingPlan\SpendingPlan;
use App\Models\SpendingPlan\SpendingPlanInstallment;
use Carbon\Carbon;
use Tests\FeatureTestCase;

class SpendingPlanCreateControllerFeatureTest extends FeatureTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        SpendingPlan::query()->delete();
        SpendingPlanInstallment::query()->delete();
    }

    protected function tearDown(): void
    {
        SpendingPlanInstallment::query()->delete();
        SpendingPlan::query()->delete();
        parent::tearDown();
    }

    public function testCreatePlanCreatesInstallments()
    {
        $due = Carbon::now()->startOfMonth()->toDateString();

        $this->postJson(route(RouteNameEnum::ApiV3SpendingPlanCreate), [
            'name' => 'Plano Internet',
            'amount' => 100.00,
            'isFixed' => false,
            'installments' => 3,
            'recurrence' => 1,
            'dueDate' => $due,
            'bankSlipCode' => '123',
        ])->assertCreated();

        $plan = SpendingPlan::firstOrFail();
        $this->assertEquals(3, $plan->installments()->count());

        $this->assertDatabaseHas(SpendingPlan::class, [
            'id' => $plan->id,
            'name' => 'Plano Internet',
            'amount' => 100.00,
            'installments_quantity' => 3,
        ]);

        $this->assertDatabaseHas(SpendingPlanInstallment::class, [
            'spending_plan_id' => $plan->id,
            'number' => 1,
            'amount' => 100.00,
        ]);
    }

    public function testRecurrenceEveryTwoMonthsSpacesDueDates()
    {
        $due = Carbon::create(2025);

        $this->postJson(route(RouteNameEnum::ApiV3SpendingPlanCreate), [
            'name' => 'Plano Academia',
            'amount' => 75.00,
            'isFixed' => false,
            'installments' => 3,
            'recurrence' => 2,
            'dueDate' => $due->toDateString(),
        ])->assertCreated();

        $plan = SpendingPlan::firstOrFail();
        $installments = $plan->installments()->orderBy('number')->get();
        $this->assertEquals('2025-01-01', Carbon::parse($installments[0]->due_date)->toDateString());
        $this->assertEquals('2025-03-01', Carbon::parse($installments[1]->due_date)->toDateString());
        $this->assertEquals('2025-05-01', Carbon::parse($installments[2]->due_date)->toDateString());
    }

    public function testMonthlySpacingWhenRecurrenceIsOne()
    {
        $due = Carbon::create(2025, 2, 15);

        $this->postJson(route(RouteNameEnum::ApiV3SpendingPlanCreate), [
            'name' => 'Plano Mensal',
            'amount' => 50.00,
            'isFixed' => false,
            'installments' => 3,
            'recurrence' => 1,
            'dueDate' => $due->toDateString(),
        ])->assertCreated();

        $plan = SpendingPlan::firstOrFail();
        $installments = $plan->installments()->orderBy('number')->get();
        $this->assertEquals('2025-02-15', Carbon::parse($installments[0]->due_date)->toDateString());
        $this->assertEquals('2025-03-15', Carbon::parse($installments[1]->due_date)->toDateString());
        $this->assertEquals('2025-04-15', Carbon::parse($installments[2]->due_date)->toDateString());
    }

    public function testFixedPlanCreatesNoInstallments()
    {
        $due = Carbon::create(2025, 6, 10);

        $this->postJson(route(RouteNameEnum::ApiV3SpendingPlanCreate), [
            'name' => 'Conta de Energia',
            'amount' => 200.00,
            'isFixed' => true,
            'installments' => 1,
            'recurrence' => 1,
            'dueDate' => $due->toDateString(),
        ])->assertCreated();

        $plan = SpendingPlan::firstOrFail();
        $this->assertTrue($plan->is_fixed);
        $this->assertEquals(0, $plan->installments_quantity);
        $this->assertEquals(0, $plan->installments()->count());
    }
}
