<?php

namespace Tests\Trait;

use App\Infra\Enum\StatusActiveInactiveEnum;
use App\Models\CreditCard\CreditCard;
use Illuminate\Foundation\Testing\WithFaker;

trait CreditCardTrait
{
    use WithFaker;

    public const string CREDIT_CARD_NAME = 'credit_card_php_unit';

    public function createCreditCard(): CreditCard
    {
        return CreditCard::create([
            'name' => self::CREDIT_CARD_NAME,
            'limit' => 1000.00,
            'due_date' => 10,
            'closing_day' => 2,
            'status' => StatusActiveInactiveEnum::Active->value,
        ]);
    }

    public function deleteCreditCard(): void
    {
        CreditCard::where('name', self::CREDIT_CARD_NAME)->delete();
    }
}
