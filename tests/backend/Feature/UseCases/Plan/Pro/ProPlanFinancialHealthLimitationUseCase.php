<?php

namespace Tests\backend\Feature\UseCases\Plan\Pro;

use App\Enums\Plan\PlanNameEnum;
use App\Models\User;
use App\Models\User\Plan;
use App\Services\Database\DatabaseConnectionService;
use Tests\backend\Falcon9Feature;

class ProPlanFinancialHealthLimitationUseCase extends Falcon9Feature
{
    private string $baseUrl = '/api/financial-health/filter';
    protected int $userPlanId = 2;

    public function testFinancialHealthFreePlanLimitation()
    {
        $response = $this->getJson($this->baseUrl, $this->makeHeaders());
        $response->assertStatus(200);
    }
}
