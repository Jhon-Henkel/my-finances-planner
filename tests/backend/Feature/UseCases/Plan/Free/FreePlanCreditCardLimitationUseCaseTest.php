<?php

namespace Tests\backend\Feature\UseCases\Plan\Free;

use App\Enums\Plan\PlanNameEnum;
use App\Models\User\Plan;
use Tests\backend\Falcon9Feature;

class FreePlanCreditCardLimitationUseCaseTest extends Falcon9Feature
{
    private Plan $plan;
    private string $baseUrl = '/api/credit-card';

    protected function setUp(): void
    {
        parent::setUp();
        $this->connectMaster();
        $this->plan = Plan::where('name', PlanNameEnum::Free->name)->first();
    }

    public function testWalletFreePlanLimitation()
    {
        for ($i = 0; $i < $this->plan->credit_card_limit; $i++) {
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
        $response->assertStatus(403);
        $response->assertJson([
            'message' => 'Limite de \'cartão de crédito\' atingido para o seu plano.',
        ]);
    }
}
