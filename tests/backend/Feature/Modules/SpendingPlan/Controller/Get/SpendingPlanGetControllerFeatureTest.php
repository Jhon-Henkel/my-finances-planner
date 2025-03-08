<?php

namespace Tests\backend\Feature\Modules\SpendingPlan\Controller\Get;

use App\Enums\Response\StatusCodeEnum;
use App\Models\WalletModel;
use App\Modules\SpendingPlan\Domain\SpendingPlanModel;
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
            'bankSlipCode' => null
        ], $this->makeApiHeaders());

        $response->assertStatus(StatusCodeEnum::HttpCreated->value);

        $response = $this->postJson('/api/v2/spending-plan', [
            'walletId' => $wallet->id,
            'description' => 'Spending Plan 6',
            'forecast' => '2021-05-20',
            'amount' => 100,
            'installments' => 2,
            'bankSlipCode' => null
        ], $this->makeApiHeaders());

        $response->assertStatus(StatusCodeEnum::HttpCreated->value);

        $item = SpendingPlanModel::query()->where('description', 'Spending Plan 5')->first();

        $response = $this->get("/api/v2/spending-plan/$item->id", $this->makeApiHeaders());

        $response->assertStatus(StatusCodeEnum::HttpOk->value);
        $response->assertJsonFragment([
            "id" => $item->id,
            "walletName" => $wallet->name,
            "walletId" => $wallet->id,
            "amount" => "100.00",
            "description" => "Spending Plan 5",
            "installments" => 2,
            "forecast" => "2021-05-20 00:00:00",
            "bankSlipCode" => null
        ]);
    }
}
