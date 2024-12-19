<?php

namespace Tests\backend\Feature\UseCases\Plan\Pro;

use App\Enums\Plan\PlanNameEnum;
use App\Enums\StatusEnum;
use App\Models\User;
use App\Models\User\Plan;
use Tests\backend\Falcon9Feature;

class ProPlanWalletLimitationUseCaseTest extends Falcon9Feature
{
    private Plan $freePlan;
    private string $baseUrl = '/api/wallet';

    protected function setUp(): void
    {
        parent::setUp();
        $this->connectMaster();
        $this->freePlan = Plan::where('name', PlanNameEnum::Free->name)->first();
        User::query()->where('email', $this->user->email)->update([
            'status' => StatusEnum::Active->value,
            'plan_id' => 2,
        ]);
    }

    protected function tearDown(): void
    {
        $this->connectMaster();
        User::query()->where('email', $this->user->email)->update([
            'status' => StatusEnum::Active->value,
            'plan_id' => 1,
        ]);
        parent::tearDown();
    }

    public function testWalletFreePlanLimitation()
    {
        for ($i = 0; $i < $this->freePlan->wallet_limit; $i++) {
            $response = $this->postJson(
                $this->baseUrl,
                [
                    'name' => $this->faker->name,
                    'amount' => $this->faker->randomFloat(2, 0, 1000),
                    'active' => $this->faker->boolean,
                ],
                $this->makeHeaders()
            );
            $response->assertStatus(201);
        }

        $response = $this->postJson(
            $this->baseUrl,
            [
                'name' => $this->faker->name,
                'amount' => $this->faker->randomFloat(2, 0, 1000),
                'active' => $this->faker->boolean,
            ],
            $this->makeHeaders()
        );
        $response->assertStatus(201);
    }
}
