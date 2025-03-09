<?php

namespace Tests\backend\Feature\Modules\Movement\Controller\Update;

use App\Enums\MovementEnum;
use App\Models\MovementModel;
use App\Models\WalletModel;
use Tests\backend\Falcon9FeatureWithTenantDatabase;

class MovementUpdateControllerFeatureTest extends Falcon9FeatureWithTenantDatabase
{
    public function testUpdateRoute()
    {
        /** @var WalletModel $wallet */
        $wallet = WalletModel::factory()->create();
        $wallet->amount = 1500;
        $wallet->save();

        $movement = MovementModel::query()->create([
            'wallet_id'  => $wallet->id,
            'description' => 'Movement 1',
            'type' => MovementEnum::Gain->value,
            'amount' => 100,
        ]);

        $response = $this->putJson('/api/v2/movement/' . $movement->id, [
            'walletId' => $wallet->id,
            'description' => 'Movement 2',
            'type' => MovementEnum::Gain->value,
            'amount' => 200,
        ], $this->makeApiHeaders());

        $response->assertStatus(200);

        $this->assertDatabaseHas('movements', [
            'description' => 'Movement 2',
            'type' => MovementEnum::Gain->value,
            'amount' => 200,
        ]);

        $wallet->refresh();

        $this->assertEquals(1600, $wallet->amount);
    }
}
