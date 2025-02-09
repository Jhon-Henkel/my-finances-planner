<?php

namespace Tests\backend\Feature\UseCases\Plan\Free;

use Tests\backend\Falcon9FeatureWithTenantDatabase;

class FreePlanFinancialHealthLimitationUseCase extends Falcon9FeatureWithTenantDatabase
{
    private string $baseUrl = '/api/financial-health/filter';

    public function testFinancialHealthFreePlanLimitation()
    {
        $response = $this->getJson($this->baseUrl, $this->makeApiHeaders());
        $response->assertStatus(403);
        $response->assertJson([
            'message' => 'Limite de \'saúde financeira\' atingido para o seu plano.',
        ]);
    }
}
