<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Wallet>
 */
class WalletFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'balance' => fake()->numberBetween(0, 1000000),
            'currency' => 'XAF',
            'status' => 'active',
        ];
    }

    /**
     * Create a wallet with zero balance
     */
    public function empty(): static
    {
        return $this->state(fn (array $attributes) => [
            'balance' => 0,
        ]);
    }

    /**
     * Create a wallet with high balance
     */
    public function wealthy(): static
    {
        return $this->state(fn (array $attributes) => [
            'balance' => fake()->numberBetween(1000000, 10000000),
        ]);
    }

    /**
     * Create a blocked wallet
     */
    public function blocked(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'blocked',
        ]);
    }
}
