<?php

namespace Feature\Modules\Wallet\Controller;

use App\Enums\RouteNameEnum;
use App\Infra\Enum\StatusActiveInactiveEnum;
use App\Infra\Enum\StatusYesNoEnum;
use App\Models\Wallet\Wallet;
use Tests\FeatureTestCase;
use Tests\Trait\WalletTrait;

class WalletCreateControllerFeatureTest extends FeatureTestCase
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
        $this->postJson(route(RouteNameEnum::ApiV3WalletCreate), [
            'name' => self::WALLET_NAME,
            'hideValue' => false,
            'amount' => 123.45,
            'status' => StatusActiveInactiveEnum::Active->value,
        ])->assertCreated();

        $this->assertDatabaseHas(Wallet::class, [
            'name' => self::WALLET_NAME,
            'amount' => 123.45,
            'status' => StatusActiveInactiveEnum::Active->value,
            'hide_value' => StatusYesNoEnum::No->value,
        ]);
    }
}
