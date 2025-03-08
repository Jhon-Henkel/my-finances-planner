<?php

namespace Tests\backend\Feature\Modules\SpendingPlan\Controller\Update;

use App\Enums\Response\StatusCodeEnum;
use App\Enums\StatusEnum;
use App\Models\WalletModel;
use App\Modules\SpendingPlan\Controller\Update\SpendingPlanUpdateController;
use App\Modules\SpendingPlan\Domain\SpendingPlanModel;
use Mockery;
use Tests\backend\Falcon9FeatureWithTenantDatabase;

class SpendingPlanUpdateControllerFeatureTest extends Falcon9FeatureWithTenantDatabase
{
    public function testUpdateEndpoint(): void
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
            'observations' => 'Observations',
            'variableSpending' => StatusEnum::Inactive->value
        ], $this->makeApiHeaders());

        $response->assertStatus(StatusCodeEnum::HttpCreated->value);

        $item = SpendingPlanModel::query()->where('description', 'Spending Plan 5')->first();

        $this->assertNotNull($item);
        $this->assertEquals($wallet->id, $item->wallet_id);
        $this->assertEquals('Spending Plan 5', $item->description);
        $this->assertEquals('2021-05-20 00:00:00', $item->forecast);
        $this->assertEquals(100, $item->amount);
        $this->assertEquals(2, $item->installments);

        $response = $this->putJson("/api/v2/spending-plan/$item->id", [
            'walletId' => $wallet->id,
            'description' => 'Spending Plan 5 Updated',
            'forecast' => '2021-05-20',
            'amount' => 100,
            'installments' => 2,
            'bankSlipCode' => '123456',
            'observations' => 'Observations Updated',
            'variableSpending' => StatusEnum::Active->value
        ], $this->makeApiHeaders());

        $response->assertStatus(StatusCodeEnum::HttpOk->value);

        $item = SpendingPlanModel::query()->where('description', 'Spending Plan 5 Updated')->first();

        $this->assertNotNull($item);
        $this->assertEquals($wallet->id, $item->wallet_id);
        $this->assertEquals('Spending Plan 5 Updated', $item->description);
        $this->assertEquals('2021-05-20 00:00:00', $item->forecast);
        $this->assertEquals(100, $item->amount);
        $this->assertEquals(2, $item->installments);
        $this->assertEquals('123456', $item->bank_slip_code);
        $this->assertEquals('Observations Updated', $item->observations);
        $this->assertEquals(StatusEnum::Active->value, $item->variable_spending);
    }

    public function testRules(): void
    {
        $controller = Mockery::mock(SpendingPlanUpdateController::class)->makePartial();
        $controller->shouldAllowMockingProtectedMethods();

        $this->assertEquals([
            'description' => 'required|max:255|string',
            'walletId' => 'required|int|exists:App\Models\WalletModel,id',
            'forecast' => 'required|date',
            'amount' => 'required|decimal:0,2',
            'installments' => 'required|int',
            'bankSlipCode' => 'string|nullable',
            'observations' => 'string|nullable',
            'variableSpending' => 'required|integer'
        ], $controller->getRules());
    }
}
