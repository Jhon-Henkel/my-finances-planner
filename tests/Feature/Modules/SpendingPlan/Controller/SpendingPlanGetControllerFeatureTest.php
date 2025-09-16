<?php

namespace Feature\Modules\SpendingPlan\Controller;

use App\Enums\RouteNameEnum;
use App\Models\SpendingPlan\SpendingPlan;
use App\Models\SpendingPlan\SpendingPlanInstallment;
use Carbon\Carbon;
use Tests\FeatureTestCase;
use Tests\Trait\WalletTrait;

class SpendingPlanGetControllerFeatureTest extends FeatureTestCase
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

    public function testGet()
    {
        $plan = SpendingPlan::create(['name' => 'Plano', 'amount' => 10, 'installments_quantity' => 2]);
        SpendingPlanInstallment::create(['spending_plan_id' => $plan->id, 'number' => 1, 'amount' => 10, 'due_date' => Carbon::now()->toDateString()]);
        SpendingPlanInstallment::create(['spending_plan_id' => $plan->id, 'number' => 2, 'amount' => 10, 'due_date' => Carbon::now()->addMonth()->toDateString()]);

        $this->getJson(route(RouteNameEnum::ApiV3SpendingPlanGet, [$plan->id]))
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
                            'spending_plan_id',
                            'number',
                            'amount',
                            'due_date',
                            'is_paid',
                            'bank_slip_code',
                            'created_at',
                            'updated_at'
                        ]
                    ]
                ]
            ]);
    }
}
