<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Investment>
 */
class InvestmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = ['active', 'completed', 'cancelled', 'pending'];
        
        return [
            'user_id' => User::factory(),
            'property_id' => Property::factory(),
            'amount' => fake()->numberBetween(10000, 500000),
            'roi' => fake()->randomFloat(2, 5, 25),
            'status' => fake()->randomElement($statuses),
            'investment_date' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }

    /**
     * Create an active investment
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Create a completed investment
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
        ]);
    }

    /**
     * Create a pending investment
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }

    /**
     * Create a high-value investment
     */
    public function highValue(): static
    {
        return $this->state(fn (array $attributes) => [
            'amount' => fake()->numberBetween(500000, 2000000),
        ]);
    }

    /**
     * Create a recent investment
     */
    public function recent(): static
    {
        return $this->state(fn (array $attributes) => [
            'investment_date' => fake()->dateTimeBetween('-1 month', 'now'),
        ]);
    }
}
