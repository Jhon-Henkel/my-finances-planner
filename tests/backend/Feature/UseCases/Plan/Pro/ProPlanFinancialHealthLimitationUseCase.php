<?php

namespace Tests\backend\Feature\UseCases\Plan\Pro;

use App\Enums\Plan\PlanNameEnum;
use App\Models\User;
use App\Models\User\Plan;
use App\Services\Database\DatabaseConnectionService;
use Tests\backend\Falcon9Feature;

class ProPlanFinancialHealthLimitationUseCase extends Falcon9Feature
{
    private array $headers;
    private string $baseUrl = '/api/financial-health/filter';

    protected function setUp(): void
    {
        parent::setUp();
        $userLoginData = $this->createNewUser();
        $login = $this->postJson('/auth', $userLoginData);
        $this->headers = $this->headerWithoutUser;
        $this->headers['X-MFP-USER-TOKEN'] = 'Bearer ' . $login->json('token');
        $connection = new DatabaseConnectionService();
        $connection->setMasterConnection();
        $user = User::where('email', $userLoginData['email'])->first();
        $user->plan_id = Plan::where('name', PlanNameEnum::Pro->name)->first()->id;
        $user->save();
    }

    public function testFinancialHealthFreePlanLimitation()
    {
        $response = $this->getJson($this->baseUrl, $this->headers);
        $response->assertStatus(200);
    }
}
