<?php

namespace Database\Factories;

use App\Models\MonthlyClosing;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MonthlyClosing>
 */
class MonthlyClosingFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $realEarning = $this->faker->randomFloat(2, 1000, 5000);
        $realExpenses = $this->faker->randomFloat(2, 1000, 5000);
        return [
            'real_earnings' => $realEarning,
            'real_expenses' => $realExpenses,
            'predicted_earnings' => $this->faker->randomFloat(2, 1000, 5000),
            'predicted_expenses' => $this->faker->randomFloat(2, 1000, 5000),
            'balance' => $realEarning - $realExpenses,
        ];
    }
}
