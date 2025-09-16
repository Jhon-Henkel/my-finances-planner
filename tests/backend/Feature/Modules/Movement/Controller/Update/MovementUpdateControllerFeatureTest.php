<?php

namespace Tests\backend\Feature\Modules\Movement\Controller\Update;

use App\Models\Movement\Movement;
use App\Models\Wallet\Wallet;
use App\Modules\Movement\Enum\MovementTypeEnum;
use Tests\backend\Falcon9FeatureWithTenantDatabase;

class MovementUpdateControllerFeatureTest extends Falcon9FeatureWithTenantDatabase
{
    public function testUpdateRoute()
    {
        /** @var Wallet $wallet */
        $wallet = Wallet::factory()->create();
        $wallet->amount = 1500;
        $wallet->save();

        $movement = Movement::query()->create([
            'wallet_id'  => $wallet->id,
            'description' => 'Movement 1',
            'type' => MovementTypeEnum::Gain->value,
            'amount' => 100,
        ]);

        $response = $this->putJson('/api/v2/movement/' . $movement->id, [
            'walletId' => $wallet->id,
            'description' => 'Movement 2',
            'type' => MovementTypeEnum::Gain->value,
            'amount' => 200,
        ], $this->makeApiHeaders());

        $response->assertStatus(200);

        $this->assertDatabaseHas('movements', [
            'description' => 'Movement 2',
            'type' => MovementTypeEnum::Gain->value,
            'amount' => 200,
        ]);

        $wallet->refresh();

        $this->assertEquals(1600, $wallet->amount);
    }
}
