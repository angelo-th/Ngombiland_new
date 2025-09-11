<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['topup', 'withdraw', 'investment', 'commission', 'refund'];
        $statuses = ['pending', 'completed', 'failed', 'cancelled'];
        
        return [
            'user_id' => User::factory(),
            'type' => fake()->randomElement($types),
            'amount' => fake()->numberBetween(1000, 1000000),
            'status' => fake()->randomElement($statuses),
            'reference' => Str::uuid(),
        ];
    }

    /**
     * Create a topup transaction
     */
    public function topup(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'topup',
            'status' => 'completed',
        ]);
    }

    /**
     * Create a withdrawal transaction
     */
    public function withdraw(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'withdraw',
            'status' => 'completed',
        ]);
    }

    /**
     * Create an investment transaction
     */
    public function investment(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'investment',
            'status' => 'completed',
        ]);
    }

    /**
     * Create a commission transaction
     */
    public function commission(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'commission',
            'status' => 'completed',
            'amount' => fake()->numberBetween(100, 10000),
        ]);
    }

    /**
     * Create a pending transaction
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }

    /**
     * Create a failed transaction
     */
    public function failed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'failed',
        ]);
    }

    /**
     * Create a recent transaction
     */
    public function recent(): static
    {
        return $this->state(fn (array $attributes) => [
            'created_at' => fake()->dateTimeBetween('-1 week', 'now'),
        ]);
    }
}
