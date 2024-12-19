<?php

namespace Tests\backend\Feature\UseCases\Plan\Pro;

use App\Enums\StatusEnum;
use App\Models\User;
use Tests\backend\Falcon9Feature;

class ProPlanFinancialHealthLimitationUseCase extends Falcon9Feature
{
    private string $baseUrl = '/api/financial-health/filter';

    protected function setUp(): void
    {
        parent::setUp();
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

    public function testFinancialHealthFreePlanLimitation()
    {
        $response = $this->getJson($this->baseUrl, $this->makeHeaders());
        $response->assertStatus(200);
    }
}
