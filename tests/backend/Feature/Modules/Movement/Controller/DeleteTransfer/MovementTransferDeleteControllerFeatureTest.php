<?php

namespace Tests\backend\Feature\Modules\Movement\Controller\DeleteTransfer;

use App\Enums\MovementEnum;
use App\Models\MovementModel;
use App\Models\WalletModel;
use Tests\backend\Falcon9FeatureWithTenantDatabase;

class MovementTransferDeleteControllerFeatureTest extends Falcon9FeatureWithTenantDatabase
{
    public function testDeleteTransferRoute()
    {
        /** @var WalletModel $originWallet */
        $originWallet = WalletModel::factory()->create();
        $originWallet->amount = 1500;
        $originWallet->save();

        /** @var WalletModel $destinationWallet */
        $destinationWallet = WalletModel::factory()->create();
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
            'type' => MovementEnum::Transfer->value,
            'amount' => 100,
            'description' => 'Saída transferência',
        ]);

        $this->assertDatabaseHas('movements', [
            'wallet_id' => $destinationWallet->id,
            'type' => MovementEnum::Transfer->value,
            'amount' => 100,
            'description' => 'Entrada transferência',
        ]);

        $originWallet->refresh();
        $destinationWallet->refresh();

        $this->assertEquals(1400, $originWallet->amount);
        $this->assertEquals(1600, $destinationWallet->amount);


        $spent = MovementModel::query()->where('description', 'Saída transferência')->first();
        $result = $this->deleteJson('/api/v2/movement/transfer/' . $spent->id, [], $this->makeApiHeaders());

        $result->assertStatus(200);

        $gain = MovementModel::query()->where('description', 'Entrada transferência')->first();
        $result = $this->deleteJson('/api/v2/movement/transfer/' . $gain->id, [], $this->makeApiHeaders());

        $result->assertStatus(200);


        $originWallet->refresh();
        $destinationWallet->refresh();

        $this->assertEquals(1500, $originWallet->amount);
        $this->assertEquals(1500, $destinationWallet->amount);
    }
}
