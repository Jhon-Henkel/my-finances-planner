<?php

namespace Feature\Modules\Wallet\Controller;

use App\Enums\RouteNameEnum;
use App\Infra\Enum\StatusActiveInactiveEnum;
use App\Infra\Enum\StatusYesNoEnum;
use App\Models\Wallet\Wallet;
use Tests\FeatureTestCase;
use Tests\Trait\WalletTrait;

class WalletUpdateControllerFeatureTest extends FeatureTestCase
{
    use WalletTrait;

    protected function setUp(): void
    {
        parent::setUp();
        $this->deleteWallet();
    }

    protected function tearDown(): void
    {
        $this->deleteWallet();
        parent::tearDown();
    }

    public function testRoute()
    {
        $wallet = $this->createWallet();

        $this->putJson(route(RouteNameEnum::ApiV3WalletUpdate, [$wallet->id]), [
            'name' => self::WALLET_NAME,
            'hideValue' => true,
            'amount' => 10,
            'status' => StatusActiveInactiveEnum::Active->value,
        ])->assertOk();

        $this->assertDatabaseHas(Wallet::class, [
            'name' => self::WALLET_NAME,
            'amount' => 10,
            'status' => StatusActiveInactiveEnum::Active->value,
            'hide_value' => StatusYesNoEnum::Yes->value,
        ]);
    }
}
