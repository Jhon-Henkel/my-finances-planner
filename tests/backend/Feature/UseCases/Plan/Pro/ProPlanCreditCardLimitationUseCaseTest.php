<?php

namespace Tests\backend\Feature\UseCases\Plan\Pro;

use App\Enums\Plan\PlanNameEnum;
use App\Models\User\Plan;
use Tests\backend\Falcon9Feature;

class ProPlanCreditCardLimitationUseCaseTest extends Falcon9Feature
{
    private Plan $freePlan;
    private string $baseUrl = '/api/credit-card';
    protected int $userPlanId = 2;

    protected function setUp(): void
    {
        parent::setUp();
        $this->connectMaster();
        $this->freePlan = Plan::where('name', PlanNameEnum::Free->value)->first();
    }

    public function testWalletFreePlanLimitation()
    {
        for ($i = 0; $i < $this->freePlan->credit_card_limit; $i++) {
            $response = $this->postJson(
                $this->baseUrl,
                [
                    'name' => $this->faker->name,
                    'limit' => $this->faker->randomFloat(2, 0, 1000),
                    'dueDate' => $this->faker->numberBetween(1, 31),
                    'closingDay' => $this->faker->numberBetween(1, 31),
                ],
                $this->makeHeaders()
            );
            $response->assertStatus(201);
        }

        $response = $this->postJson(
            $this->baseUrl,
            [
                'name' => $this->faker->name,
                'limit' => $this->faker->randomFloat(2, 0, 1000),
                'dueDate' => $this->faker->numberBetween(1, 31),
                'closingDay' => $this->faker->numberBetween(1, 31),
            ],
            $this->makeHeaders()
        );
        $response->assertStatus(201);
    }
}
