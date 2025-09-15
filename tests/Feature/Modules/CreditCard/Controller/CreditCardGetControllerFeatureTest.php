<?php

namespace Feature\Modules\CreditCard\Controller;

use App\Enums\RouteNameEnum;
use Tests\FeatureTestCase;
use Tests\Trait\CreditCardTrait;

class CreditCardGetControllerFeatureTest extends FeatureTestCase
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

        $this->getJson(route(RouteNameEnum::ApiV3CreditCardGet, [$card->id]))->assertOk()->assertJsonStructure([
            'status',
            'data' => [
                'id',
                'name',
                'limit',
                'due_date',
                'closing_day',
                'status',
            ]
        ]);
    }
}
