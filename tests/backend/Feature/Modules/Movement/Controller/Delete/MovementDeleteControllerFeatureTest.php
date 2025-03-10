<?php

namespace Tests\backend\Feature\Modules\Movement\Controller\Delete;

use App\Enums\MovementEnum;
use App\Models\MovementModel;
use App\Models\WalletModel;
use Tests\backend\Falcon9FeatureWithTenantDatabase;

class MovementDeleteControllerFeatureTest extends Falcon9FeatureWithTenantDatabase
{
    public function testDeleteMovementRoute(): void
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

        $movement = MovementModel::query()->where('description', 'Movement 1')->first();

        $response = $this->deleteJson('/api/v2/movement/' . $movement->id, [], $this->makeApiHeaders());

        $response->assertStatus(200);

        $this->assertDatabaseMissing('movements', [
            'description' => 'Movement 1',
            'type' => MovementEnum::Spent->value,
            'amount' => 100,
        ]);

        $wallet->refresh();

        $this->assertEquals(1500, $wallet->amount);
    }
}
