<?php

namespace Feature\Modules\EarningPlan\Controller;

use App\Enums\RouteNameEnum;
use App\Models\EarningPlan\EarningPlan;
use App\Models\EarningPlan\EarningPlanInstallment;
use Carbon\Carbon;
use Tests\FeatureTestCase;

class EarningPlanGetControllerFeatureTest extends FeatureTestCase
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

    public function testGet()
    {
        $plan = EarningPlan::create(['name' => 'Plano', 'amount' => 10, 'installments_quantity' => 2]);
        EarningPlanInstallment::create(['earning_plan_id' => $plan->id, 'number' => 1, 'amount' => 10, 'due_date' => Carbon::now()->toDateString()]);
        EarningPlanInstallment::create(['earning_plan_id' => $plan->id, 'number' => 2, 'amount' => 10, 'due_date' => Carbon::now()->addMonth()->toDateString()]);

        $this->getJson(route(RouteNameEnum::ApiV3EarningPlanGet, [$plan->id]))
            ->assertOk()
            ->assertJsonStructure([
                'status',
                'data' => [
                    'id',
                    'name',
                    'amount',
                    'installments_quantity',
                    'recurrence',
                    'created_at',
                    'updated_at',
                    'installments' => [
                        [
                            'id',
                            'earning_plan_id',
                            'number',
                            'amount',
                            'due_date',
                            'is_received',
                            'created_at',
                            'updated_at'
                        ]
                    ]
                ]
            ]);
    }
}
