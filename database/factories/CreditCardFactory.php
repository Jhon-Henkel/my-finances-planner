<?php

namespace Database\Factories;

use App\Models\CreditCard;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CreditCard>
 */
class CreditCardFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'limit' => $this->faker->randomFloat(2, 5000, 10000),
            'due_date' => $this->faker->numberBetween(1, 28),
            'closing_day' => $this->faker->numberBetween(1, 28),
        ];
    }
}