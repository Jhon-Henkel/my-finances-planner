<?php

namespace Tests\backend\Feature\Modules\Movement\Controller\Delete;

use App\Models\Movement\Movement;
use App\Models\Wallet\Wallet;
use App\Modules\Movement\Enum\MovementTypeEnum;
use Tests\backend\Falcon9FeatureWithTenantDatabase;

class MovementDeleteControllerFeatureTest extends Falcon9FeatureWithTenantDatabase
{
    public function testDeleteMovementRoute(): void
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

        $movement = Movement::query()->where('description', 'Movement 1')->first();

        $response = $this->deleteJson('/api/v2/movement/' . $movement->id, [], $this->makeApiHeaders());

        $response->assertStatus(200);

        $this->assertDatabaseMissing('movements', [
            'description' => 'Movement 1',
            'type' => MovementTypeEnum::Spent->value,
            'amount' => 100,
        ]);

        $wallet->refresh();

        $this->assertEquals(1500, $wallet->amount);
    }
}
