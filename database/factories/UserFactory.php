<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => '+237' . fake()->numerify('########'),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => fake()->randomElement(['client', 'proprietor', 'investor', 'agent']),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Create an admin user
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
            'email' => 'admin@ngombiland.cm',
        ]);
    }

    /**
     * Create a proprietor user
     */
    public function proprietor(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'proprietor',
        ]);
    }

    /**
     * Create an investor user
     */
    public function investor(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'investor',
        ]);
    }

    /**
     * Create a client user
     */
    public function client(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'client',
        ]);
    }
}