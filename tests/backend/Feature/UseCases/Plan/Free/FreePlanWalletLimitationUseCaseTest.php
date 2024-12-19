<?php

namespace Tests\backend\Feature\UseCases\Plan\Free;

use App\Enums\Plan\PlanNameEnum;
use App\Enums\StatusEnum;
use App\Models\User;
use App\Models\User\Plan;
use Tests\backend\Falcon9Feature;

class FreePlanWalletLimitationUseCaseTest extends Falcon9Feature
{
    private Plan $plan;
    private string $baseUrl = '/api/wallet';

    protected function setUp(): void
    {
        $this->markTestSkipped('Tem algum loop aqui...');
        parent::setUp();
        $this->connectMaster();
        $this->plan = Plan::where('name', PlanNameEnum::Free->name)->first();
        User::query()->where('email', $this->user->email)->update([
            'status' => StatusEnum::Active->value,
            'plan_id' => 1,
        ]);
    }

    public function testWalletFreePlanLimitation()
    {
        for ($i = 0; $i < $this->plan->wallet_limit; $i++) {
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
        $response->assertStatus(403);
        $response->assertJson([
            'message' => 'Limite de \'carteiras\' atingido para o seu plano.',
        ]);
    }
}
