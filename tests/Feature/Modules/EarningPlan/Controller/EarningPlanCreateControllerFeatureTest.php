<?php

namespace Feature\Modules\EarningPlan\Controller;

use App\Enums\RouteNameEnum;
use App\Models\EarningPlan\EarningPlan;
use App\Models\EarningPlan\EarningPlanInstallment;
use Carbon\Carbon;
use Tests\FeatureTestCase;

class EarningPlanCreateControllerFeatureTest extends FeatureTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        EarningPlan::query()->delete();
        EarningPlanInstallment::query()->delete();
    }

    protected function tearDown(): void
    {
        EarningPlanInstallment::query()->delete();
        EarningPlan::query()->delete();
        parent::tearDown();
    }

    public function testCreatePlanCreatesInstallments()
    {
        $due = Carbon::now()->startOfMonth()->toDateString();

        $this->postJson(route(RouteNameEnum::ApiV3EarningPlanCreate), [
            'name' => 'Plano Salário',
            'amount' => 1000.00,
            'isFixed' => false,
            'installments' => 3,
            'recurrence' => 1,
            'dueDate' => $due,
        ])->assertCreated();

        $plan = EarningPlan::firstOrFail();
        $this->assertEquals(3, $plan->installments()->count());

        $this->assertDatabaseHas(EarningPlan::class, [
            'id' => $plan->id,
            'name' => 'Plano Salário',
            'amount' => 1000.00,
            'installments_quantity' => 3,
        ]);

        $this->assertDatabaseHas(EarningPlanInstallment::class, [
            'earning_plan_id' => $plan->id,
            'number' => 1,
            'amount' => 1000.00,
        ]);
    }

    public function testRecurrenceEveryTwoMonthsSpacesDueDates()
    {
        $due = Carbon::create(2025);

        $this->postJson(route(RouteNameEnum::ApiV3EarningPlanCreate), [
            'name' => 'Plano Bônus',
            'amount' => 750.00,
            'isFixed' => false,
            'installments' => 3,
            'recurrence' => 2,
            'dueDate' => $due->toDateString(),
        ])->assertCreated();

        $plan = EarningPlan::firstOrFail();
        $installments = $plan->installments()->orderBy('number')->get();
        $this->assertEquals('2025-01-01', Carbon::parse($installments[0]->due_date)->toDateString());
        $this->assertEquals('2025-03-01', Carbon::parse($installments[1]->due_date)->toDateString());
        $this->assertEquals('2025-05-01', Carbon::parse($installments[2]->due_date)->toDateString());
    }

    public function testMonthlySpacingWhenRecurrenceIsOne()
    {
        $due = Carbon::create(2025, 2, 15);

        $this->postJson(route(RouteNameEnum::ApiV3EarningPlanCreate), [
            'name' => 'Plano Mensal Entrada',
            'amount' => 500.00,
            'isFixed' => false,
            'installments' => 3,
            'recurrence' => 1,
            'dueDate' => $due->toDateString(),
        ])->assertCreated();

        $plan = EarningPlan::firstOrFail();
        $installments = $plan->installments()->orderBy('number')->get();
        $this->assertEquals('2025-02-15', Carbon::parse($installments[0]->due_date)->toDateString());
        $this->assertEquals('2025-03-15', Carbon::parse($installments[1]->due_date)->toDateString());
        $this->assertEquals('2025-04-15', Carbon::parse($installments[2]->due_date)->toDateString());
    }

    public function testFixedPlanCreatesNoInstallments()
    {
        $due = Carbon::create(2025, 6, 10);

        $this->postJson(route(RouteNameEnum::ApiV3EarningPlanCreate), [
            'name' => 'Entrada Fixa',
            'amount' => 1200.00,
            'isFixed' => true,
            'installments' => 1,
            'recurrence' => 1,
            'dueDate' => $due->toDateString(),
        ])->assertCreated();

        $plan = EarningPlan::firstOrFail();
        $this->assertTrue($plan->is_fixed);
        $this->assertEquals(0, $plan->installments_quantity);
        $this->assertEquals(0, $plan->installments()->count());
    }
}
