<?php

namespace Tests\backend\Feature\UseCases\Plan;

use App\Enums\Plan\PlanNameEnum;
use App\Models\User\Plan;
use App\Services\Database\DatabaseConnectionService;
use Tests\backend\Falcon9Feature;

class FreePlanWalletLimitationUseCaseTest extends Falcon9Feature
{
    private array $headers;
    private Plan $plan;
    private string $baseUrl = '/api/wallet';

    protected function setUp(): void
    {
        parent::setUp();
        $userLoginData = $this->createNewUser();
        $login = $this->postJson('/auth', $userLoginData);
        $this->headers = $this->headerWithoutUser;
        $this->headers['X-MFP-USER-TOKEN'] = 'Bearer ' . $login->json('token');
        $connection = new DatabaseConnectionService();
        $connection->setMasterConnection();
        $this->plan = Plan::where('name', PlanNameEnum::Free->name)->first();
    }

    public function testWalletFreePlanLimitation()
    {
        for ($i = 0; $i < $this->plan->wallet_limit; $i++) {
            $response = $this->postJson(
                $this->baseUrl,
                [
                    'name' => $this->faker->name,
                    'amount' => $this->faker->randomFloat(2, 0, 1000),
                ],
                $this->headers
            );
            $response->assertStatus(201);
        }

        $response = $this->postJson(
            $this->baseUrl,
            [
                'name' => $this->faker->name,
                'amount' => $this->faker->randomFloat(2, 0, 1000),
            ],
            $this->headers
        );
        $response->assertStatus(403);
        $response->assertJson([
            'message' => 'Limite de \'carteiras\' atingido para o seu plano.',
        ]);
    }
}
