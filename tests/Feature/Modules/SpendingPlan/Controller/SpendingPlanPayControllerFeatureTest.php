<?php

namespace Feature\Modules\SpendingPlan\Controller;

use App\Enums\RouteNameEnum;
use App\Models\Movement\Movement;
use App\Models\SpendingPlan\SpendingPlan;
use App\Models\SpendingPlan\SpendingPlanInstallment;
use App\Modules\Movement\Enum\MovementTypeEnum;
use Carbon\Carbon;
use Tests\FeatureTestCase;
use Tests\Trait\WalletTrait;

class SpendingPlanPayControllerFeatureTest extends FeatureTestCase
{
    use WalletTrait;

    protected function setUp(): void
    {
        parent::setUp();
        SpendingPlanInstallment::query()->delete();
        SpendingPlan::query()->delete();
        Movement::query()->delete();
        $this->deleteWallet();
    }

    protected function tearDown(): void
    {
        SpendingPlanInstallment::query()->delete();
        SpendingPlan::query()->delete();
        Movement::query()->delete();
        $this->deleteWallet();
        parent::tearDown();
    }

    public function testPayNonFixedMarksInstallmentAndCreatesMovement()
    {
        $wallet = $this->createWallet();
        $plan = SpendingPlan::create(['name' => 'Plano Despesa', 'amount' => 20, 'is_fixed' => false, 'installments_quantity' => 2, 'recurrence' => 1]);
        SpendingPlanInstallment::create(['spending_plan_id' => $plan->id, 'number' => 1, 'amount' => 20, 'due_date' => Carbon::now()->toDateString(), 'is_paid' => false]);

        $this->postJson(route(RouteNameEnum::ApiV3SpendingPlanPay), [
            'planId' => $plan->id,
            'walletId' => $wallet->id,
            'installmentNumber' => 1,
        ])->assertCreated();

        $this->assertDatabaseHas(SpendingPlanInstallment::class, [
            'spending_plan_id' => $plan->id,
            'number' => 1,
            'is_paid' => true,
        ]);

        $this->assertDatabaseHas(Movement::class, [
            'wallet_id' => $wallet->id,
            'type' => MovementTypeEnum::Spent->value,
            'amount' => 20.00,
        ]);
    }

    public function testPayFixedCreatesMovementOnly()
    {
        $wallet = $this->createWallet();
        $plan = SpendingPlan::create(['name' => 'Conta de Luz', 'amount' => 150, 'is_fixed' => true, 'installments_quantity' => 0, 'recurrence' => 1]);

        $this->postJson(route(RouteNameEnum::ApiV3SpendingPlanPay), [
            'planId' => $plan->id,
            'walletId' => $wallet->id,
        ])->assertCreated();

        $this->assertDatabaseHas(Movement::class, [
            'wallet_id' => $wallet->id,
            'type' => MovementTypeEnum::Spent->value,
            'amount' => 150.00,
        ]);
    }
}
