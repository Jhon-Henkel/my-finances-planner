<?php

namespace Tests\backend\Feature\Modules\Movement\Controller\Insert;

use App\Enums\MovementEnum;
use App\Models\WalletModel;
use Tests\backend\Falcon9FeatureWithTenantDatabase;

class MovementInsertControllerFeatureTest extends Falcon9FeatureWithTenantDatabase
{
    public function testInsertSpent(): void
    {
        /** @var WalletModel $wallet */
        $wallet = WalletModel::factory()->create();
        $wallet->amount = 1500;
        $wallet->save();

        $response = $this->postJson('/api/v2/movement', [
            'walletId' => $wallet->id,
            'description' => 'Movement 1',
            'type' => MovementEnum::Spent->value,
            'amount' => 100,
        ], $this->makeApiHeaders());

        $response->assertStatus(201);

        $this->assertDatabaseHas('movements', [
            'description' => 'Movement 1',
            'type' => MovementEnum::Spent->value,
            'amount' => 100,
        ]);

        $wallet->refresh();

        $this->assertEquals(1400, $wallet->amount);
    }

    public function testInsertGain()
    {
        /** @var WalletModel $wallet */
        $wallet = WalletModel::factory()->create();
        $wallet->amount = 1500;
        $wallet->save();

        $response = $this->postJson('/api/v2/movement', [
            'walletId' => $wallet->id,
            'description' => 'Movement 1',
            'type' => MovementEnum::Gain->value,
            'amount' => 100,
        ], $this->makeApiHeaders());

        $response->assertStatus(201);

        $this->assertDatabaseHas('movements', [
            'description' => 'Movement 1',
            'type' => MovementEnum::Gain->value,
            'amount' => 100,
        ]);

        $wallet->refresh();

        $this->assertEquals(1600, $wallet->amount);
    }
}
