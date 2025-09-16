<?php

namespace Tests\Trait;

use App\Infra\Enum\StatusActiveInactiveEnum;
use App\Models\Wallet\Wallet;
use Illuminate\Foundation\Testing\WithFaker;

trait WalletTrait
{
    use WithFaker;

    public const string WALLET_NAME = 'wallet_php_unit';

    public function createWallet(): Wallet
    {
        return Wallet::create([
            'name' => self::WALLET_NAME,
            'status' => StatusActiveInactiveEnum::Active->value,
            'amount' => 100.00,
            'hide_value' => false,
        ]);
    }

    public function deleteWallet(): void
    {
        Wallet::where('name', self::WALLET_NAME)->delete();
    }
}
