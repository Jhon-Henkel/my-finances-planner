<?php

namespace Feature\Modules\EarningPlan\Controller;

use App\Enums\RouteNameEnum;
use App\Models\EarningPlan\EarningPlan;
use App\Models\EarningPlan\EarningPlanInstallment;
use App\Models\Movement\Movement;
use App\Modules\Movement\Enum\MovementTypeEnum;
use Carbon\Carbon;
use Tests\FeatureTestCase;
use Tests\Trait\WalletTrait;

class EarningPlanReceiveControllerFeatureTest extends FeatureTestCase
{
    use WalletTrait;

    protected function setUp(): void
    {
        parent::setUp();
        EarningPlanInstallment::query()->delete();
        EarningPlan::query()->delete();
        Movement::query()->delete();
        $this->deleteWallet();
    }

    protected function tearDown(): void
    {
        EarningPlanInstallment::query()->delete();
        EarningPlan::query()->delete();
        Movement::query()->delete();
        $this->deleteWallet();
        parent::tearDown();
    }

    public function testReceiveNonFixedMarksInstallmentAndCreatesMovement()
    {
        $wallet = $this->createWallet();
        $plan = EarningPlan::create(['name' => 'Plano Ganho', 'amount' => 10, 'is_fixed' => false, 'installments_quantity' => 2, 'recurrence' => 1]);
        EarningPlanInstallment::create(['earning_plan_id' => $plan->id, 'number' => 1, 'amount' => 10, 'due_date' => Carbon::now()->toDateString(), 'is_received' => false]);

        $this->postJson(route(RouteNameEnum::ApiV3EarningPlanReceive), [
            'planId' => $plan->id,
            'walletId' => $wallet->id,
            'installmentNumber' => 1,
        ])->assertCreated();

        $this->assertDatabaseHas(EarningPlanInstallment::class, [
            'earning_plan_id' => $plan->id,
            'number' => 1,
            'is_received' => true,
        ]);

        $this->assertDatabaseHas(Movement::class, [
            'wallet_id' => $wallet->id,
            'type' => MovementTypeEnum::Gain->value,
            'amount' => 10.00,
        ]);
    }

    public function testReceiveFixedCreatesMovementOnly()
    {
        $wallet = $this->createWallet();
        $plan = EarningPlan::create(['name' => 'Salário', 'amount' => 1000, 'is_fixed' => true, 'installments_quantity' => 0, 'recurrence' => 1]);

        $this->postJson(route(RouteNameEnum::ApiV3EarningPlanReceive), [
            'planId' => $plan->id,
            'walletId' => $wallet->id,
        ])->assertCreated();

        $this->assertDatabaseHas(Movement::class, [
            'wallet_id' => $wallet->id,
            'type' => MovementTypeEnum::Gain->value,
            'amount' => 1000.00,
        ]);
    }
}
