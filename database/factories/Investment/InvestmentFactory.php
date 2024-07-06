<?php

namespace Database\Factories\Investment;

use App\Models\CreditCard;
use App\Models\Investment\Investment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Investment>
 */
class InvestmentFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $creditCards = CreditCard::all()->toArray();
        $creditCardIds = [];
        foreach ($creditCards as $creditCard) {
            $creditCardIds[] = $creditCard['id'];
        }
        return [
            'amount' => $this->faker->randomFloat(2, 1000, 5000),
            'liquidity' => $this->faker->numberBetween(0, 31),
            'profitability' => $this->faker->numberBetween(1, 100),
            'type' => $this->faker->numberBetween(1, 2),
            'description' => $this->faker->text(10),
            'credit_card_id' => $this->faker->randomElement($creditCardIds),
        ];
    }
}
