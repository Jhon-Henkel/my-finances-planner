<?php

namespace Database\Factories;

use App\Models\FutureSpent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FutureSpent>
 */
class FutureSpentFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => $this->faker->randomFloat(2, 1000, 5000),
            'installments' => $this->faker->numberBetween(0, 6),
        ];
    }
}
