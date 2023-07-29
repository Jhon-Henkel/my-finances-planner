<?php

namespace Database\Factories;

use App\Models\MovementModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MovementModel>
 */
class MovementModelFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => $this->faker->randomFloat(2, 1000, 5000),
        ];
    }
}