<?php

namespace Tests\backend\Feature\Modules\Movement\Controller\InsertTransfer;

use App\Models\Wallet\Wallet;
use App\Modules\Movement\Enum\MovementTypeEnum;
use Tests\backend\Falcon9FeatureWithTenantDatabase;

class MovementTransferInsertControllerFeatureTest extends Falcon9FeatureWithTenantDatabase
{
    public function testInsertTransferRoute()
    {
        /** @var Wallet $originWallet */
        $originWallet = Wallet::factory()->create();
        $originWallet->amount = 1500;
        $originWallet->save();

        /** @var Wallet $destinationWallet */
        $destinationWallet = Wallet::factory()->create();
        $destinationWallet->amount = 1500;
        $destinationWallet->save();

        $response = $this->postJson('/api/v2/movement/transfer', [
            'originId' => $originWallet->id,
            'destinationId' => $destinationWallet->id,
            'amount' => 100,
        ], $this->makeApiHeaders());

        $response->assertStatus(201);

        $this->assertDatabaseHas('movements', [
            'wallet_id' => $originWallet->id,
            'type' => MovementTypeEnum::Transfer->value,
            'amount' => 100,
            'description' => 'Saída transferência',
        ]);

        $this->assertDatabaseHas('movements', [
            'wallet_id' => $destinationWallet->id,
            'type' => MovementTypeEnum::Transfer->value,
            'amount' => 100,
            'description' => 'Entrada transferência',
        ]);

        $originWallet->refresh();
        $destinationWallet->refresh();

        $this->assertEquals(1400, $originWallet->amount);
        $this->assertEquals(1600, $destinationWallet->amount);
    }
}
