<?php

namespace Tests\backend\Feature\CompleteFeature;

use App\Enums\MovementEnum;
use App\Enums\WalletTypeEnum;
use Illuminate\Support\Facades\DB;
use Tests\backend\Falcon9Feature;

class MovementFeatureTest extends Falcon9Feature
{
    protected function setUp(): void
    {
        parent::setUp();
        DB::delete('DELETE FROM movements WHERE description = ?', ['Teste de movimentação']);
        DB::delete('DELETE FROM wallets WHERE name = ?', ['wallet_feature_test']);
    }

    protected function tearDown(): void
    {
        DB::delete('DELETE FROM movements WHERE description = ?', ['Teste de movimentação']);
        DB::delete('DELETE FROM wallets WHERE name = ?', ['wallet_feature_test']);
        parent::tearDown();
    }

    public function testMovementSpentUpdate()
    {
        $wallet = $this->postJson('/api/wallet', [
            'name' => 'wallet_feature_test',
            'type' => WalletTypeEnum::Other->value,
            'amount' => 150
        ], $this->makeHeaders());
        $wallet = $wallet->getOriginalContent();

        $movementInsert = $this->postJson('/api/movement', [
            'wallet_id' => $wallet->id,
            'amount' => 10,
            'type' => MovementEnum::Spent->value,
            'walletId' => $wallet->id,
            'description' => 'Teste de movimentação'
        ], $this->makeHeaders());
        $movementInsert = $movementInsert->getOriginalContent();

        $getWallet = $this->getJson('/api/wallet/' . $wallet->id, $this->makeHeaders());
        $getWallet = $getWallet->getOriginalContent();

        $this->assertEquals(140, $getWallet->amount);

        $this->putJson('/api/movement/' . $movementInsert->id, [
            'wallet_id' => $wallet->id,
            'amount' => 20,
            'type' => MovementEnum::Spent->value,
            'walletId' => $wallet->id,
            'description' => 'Teste de movimentação'
        ], $this->makeHeaders());

        $getWallet = $this->getJson('/api/wallet/' . $wallet->id, $this->makeHeaders());
        $getWallet = $getWallet->getOriginalContent();

        $this->assertEquals(130, $getWallet->amount);
    }

    public function testMovementGainUpdate()
    {
        $wallet = $this->postJson('/api/wallet', [
            'name' => 'wallet_feature_test',
            'type' => WalletTypeEnum::Other->value,
            'amount' => 150
        ], $this->makeHeaders());
        $wallet = $wallet->getOriginalContent();

        $movementInsert = $this->postJson('/api/movement', [
            'wallet_id' => $wallet->id,
            'amount' => 10,
            'type' => MovementEnum::Gain->value,
            'walletId' => $wallet->id,
            'description' => 'Teste de movimentação'
        ], $this->makeHeaders());
        $movementInsert = $movementInsert->getOriginalContent();

        $getWallet = $this->getJson('/api/wallet/' . $wallet->id, $this->makeHeaders());
        $getWallet = $getWallet->getOriginalContent();

        $this->assertEquals(160, $getWallet->amount);

        $this->putJson('/api/movement/' . $movementInsert->id, [
            'wallet_id' => $wallet->id,
            'amount' => 20,
            'type' => MovementEnum::Gain,
            'walletId' => $wallet->id,
            'description' => 'Teste de movimentação'
        ], $this->makeHeaders());

        $getWallet = $this->getJson('/api/wallet/' . $wallet->id, $this->makeHeaders());
        $getWallet = $getWallet->getOriginalContent();

        $this->assertEquals(170, $getWallet->amount);
    }
}