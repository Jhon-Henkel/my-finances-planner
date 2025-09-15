<?php

namespace Database\Factories;

use App\Models\Wallet\Wallet;
use App\Modules\Old\Wallet\Enum\WalletTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Wallet>
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
            'type' => WalletTypeEnum::Other->value,
        ];
    }
}
