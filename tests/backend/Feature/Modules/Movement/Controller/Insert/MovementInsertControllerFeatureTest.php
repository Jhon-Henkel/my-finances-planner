<?php

namespace Tests\backend\Feature\Modules\Movement\Controller\Insert;

use App\Models\Wallet\Wallet;
use App\Modules\Movement\Enum\MovementTypeEnum;
use Tests\backend\Falcon9FeatureWithTenantDatabase;

class MovementInsertControllerFeatureTest extends Falcon9FeatureWithTenantDatabase
{
    public function testInsertSpent(): void
    {
        /** @var Wallet $wallet */
        $wallet = Wallet::factory()->create();
        $wallet->amount = 1500;
        $wallet->save();

        $response = $this->postJson('/api/v2/movement', [
            'walletId' => $wallet->id,
            'description' => 'Movement 1',
            'type' => MovementTypeEnum::Spent->value,
            'amount' => 100,
        ], $this->makeApiHeaders());

        $response->assertStatus(201);

        $this->assertDatabaseHas('movements', [
            'description' => 'Movement 1',
            'type' => MovementTypeEnum::Spent->value,
            'amount' => 100,
        ]);

        $wallet->refresh();

        $this->assertEquals(1400, $wallet->amount);
    }

    public function testInsertGain()
    {
        /** @var Wallet $wallet */
        $wallet = Wallet::factory()->create();
        $wallet->amount = 1500;
        $wallet->save();

        $response = $this->postJson('/api/v2/movement', [
            'walletId' => $wallet->id,
            'description' => 'Movement 1',
            'type' => MovementTypeEnum::Gain->value,
            'amount' => 100,
        ], $this->makeApiHeaders());

        $response->assertStatus(201);

        $this->assertDatabaseHas('movements', [
            'description' => 'Movement 1',
            'type' => MovementTypeEnum::Gain->value,
            'amount' => 100,
        ]);

        $wallet->refresh();

        $this->assertEquals(1600, $wallet->amount);
    }
}
