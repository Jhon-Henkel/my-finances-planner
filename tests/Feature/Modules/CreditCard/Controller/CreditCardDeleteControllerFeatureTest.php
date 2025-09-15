<?php

namespace Feature\Modules\CreditCard\Controller;

use App\Enums\RouteNameEnum;
use App\Models\CreditCard\CreditCard;
use Tests\FeatureTestCase;
use Tests\Trait\CreditCardTrait;

class CreditCardDeleteControllerFeatureTest extends FeatureTestCase
{
    use CreditCardTrait;

    protected function setUp(): void
    {
        parent::setUp();
        $this->deleteCreditCard();
    }

    protected function tearDown(): void
    {
        $this->deleteCreditCard();
        parent::tearDown();
    }

    public function testRoute()
    {
        $card = $this->createCreditCard();

        $this->deleteJson(route(RouteNameEnum::ApiV3CreditCardDelete, [$card->id]))->assertNoContent();

        $this->assertDatabaseMissing(CreditCard::class, [
            'id' => $card->id,
        ]);
    }
}
