<?php

namespace Database\Factories;

use App\Enums\WalletTypeEnum;
use App\Models\WalletModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<WalletModel>
 */
class WalletModelFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => $this->faker->randomFloat(2, 1, 10000),
            'name' => $this->faker->name,
            'type' => $this->faker->randomElement([WalletTypeEnum::Money->value, WalletTypeEnum::Other->value]),
        ];
    }
}