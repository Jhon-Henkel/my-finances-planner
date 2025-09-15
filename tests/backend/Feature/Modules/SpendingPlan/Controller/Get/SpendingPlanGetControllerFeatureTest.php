<?php

namespace Tests\backend\Feature\Modules\SpendingPlan\Controller\Get;

use App\Enums\Response\HttpStatusCodeEnum;
use App\Enums\StatusEnum;
use App\Models\WalletModel;
use App\Modules\Old\SpendingPlan\Domain\SpendingPlanModel;
use Tests\backend\Falcon9FeatureWithTenantDatabase;

class SpendingPlanGetControllerFeatureTest extends Falcon9FeatureWithTenantDatabase
{
    public function testGetEndpoint(): void
    {
        /** @var WalletModel $wallet */
        $wallet = WalletModel::factory()->create();

        $response = $this->postJson('/api/v2/spending-plan', [
            'walletId' => $wallet->id,
            'description' => 'Spending Plan 5',
            'forecast' => '2021-05-20',
            'amount' => 100,
            'installments' => 2,
            'bankSlipCode' => null,
            'observations' => null,
            'variableSpending' => StatusEnum::Inactive->value
        ], $this->makeApiHeaders());

        $response->assertStatus(HttpStatusCodeEnum::HttpCreated->value);

        $response = $this->postJson('/api/v2/spending-plan', [
            'walletId' => $wallet->id,
            'description' => 'Spending Plan 6',
            'forecast' => '2021-05-20',
            'amount' => 100,
            'installments' => 2,
            'bankSlipCode' => null,
            'observations' => null,
            'variableSpending' => StatusEnum::Inactive->value
        ], $this->makeApiHeaders());

        $response->assertStatus(HttpStatusCodeEnum::HttpCreated->value);

        $item = SpendingPlanModel::query()->where('description', 'Spending Plan 5')->first();

        $response = $this->get("/api/v2/spending-plan/$item->id", $this->makeApiHeaders());

        $response->assertStatus(HttpStatusCodeEnum::HttpOk->value);
        $response->assertJsonFragment([
            "id" => $item->id,
            "walletName" => $wallet->name,
            "walletId" => $wallet->id,
            "amount" => 100.00,
            "description" => "Spending Plan 5",
            "installments" => 2,
            "forecast" => "2021-05-20 00:00:00",
            "bankSlipCode" => null,
            "observations" => null,
            "variable_spending" => StatusEnum::Inactive->value
        ]);
    }
}
