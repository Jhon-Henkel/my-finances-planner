<?php

namespace Tests\backend\Feature\Modules\SpendingPlan\Controller\Insert;

use App\Enums\Response\HttpStatusCodeEnum;
use App\Enums\StatusEnum;
use App\Models\WalletModel;
use App\Modules\Old\SpendingPlan\Controller\Insert\SpendingPlanCreateController;
use App\Modules\Old\SpendingPlan\Domain\SpendingPlanModel;
use Mockery;
use Tests\backend\Falcon9FeatureWithTenantDatabase;

class SpendingPlanInsertControllerFeatureTest extends Falcon9FeatureWithTenantDatabase
{
    public function testInsertEndpoint(): void
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

        $item = SpendingPlanModel::query()->where('description', 'Spending Plan 5')->first();

        $this->assertNotNull($item);
        $this->assertEquals($wallet->id, $item->wallet_id);
        $this->assertEquals('Spending Plan 5', $item->description);
        $this->assertEquals('2021-05-20 00:00:00', $item->forecast);
        $this->assertEquals(100, $item->amount);
        $this->assertEquals(2, $item->installments);
        $this->assertNull($item->bank_slip_code);
        $this->assertNull($item->observations);
        $this->assertEquals(StatusEnum::Inactive->value, $item->variable_spending);
    }

    public function testRules(): void
    {
        $controller = Mockery::mock(SpendingPlanCreateController::class)->makePartial();
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
