<?php

namespace Database\Factories;

use App\Models\CreditCardTransaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CreditCardTransaction>
 */
class CreditCardTransactionFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'value' => $this->faker->randomFloat(2, 5, 150),
            'installments' => $this->faker->numberBetween(0, 8),
        ];
    }
}
