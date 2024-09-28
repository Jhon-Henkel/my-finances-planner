<?php

namespace Tests\backend\Feature\UseCases\Plan\Free;

use App\Services\Database\DatabaseConnectionService;
use Tests\backend\Falcon9Feature;

class FreePlanFinancialHealthLimitationUseCase extends Falcon9Feature
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
    }

    public function testFinancialHealthFreePlanLimitation()
    {
        $response = $this->getJson($this->baseUrl, $this->headers);
        $response->assertStatus(403);
        $response->assertJson([
            'message' => 'Limite de \'saúde financeira\' atingido para o seu plano.',
        ]);
    }
}
