<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['villa', 'apartment', 'house', 'land', 'commercial'];
        $statuses = ['pending', 'approved', 'rejected'];
        $locations = [
            'Douala, Cameroun',
            'Yaoundé, Cameroun',
            'Bafoussam, Cameroun',
            'Garoua, Cameroun',
            'Maroua, Cameroun',
        ];

        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(3),
            'price' => fake()->numberBetween(1000000, 100000000),
            'location' => fake()->randomElement($locations),
            'latitude' => fake()->latitude(2.0, 13.0), // Cameroon latitude range
            'longitude' => fake()->longitude(8.0, 17.0), // Cameroon longitude range
            'status' => fake()->randomElement($statuses),
            'type' => fake()->randomElement($types),
            'images' => [
                'property_'.fake()->uuid().'.jpg',
                'property_'.fake()->uuid().'.jpg',
                'property_'.fake()->uuid().'.jpg',
            ],
            'is_crowdfundable' => fake()->boolean(30), // 30% chance of being crowdfundable
            'expected_roi' => fake()->randomFloat(2, 8, 20), // ROI between 8% and 20%
        ];
    }

    /**
     * Create a crowdfundable property
     */
    public function crowdfundable(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_crowdfundable' => true,
            'expected_roi' => fake()->randomFloat(2, 10, 25),
        ]);
    }

    /**
     * Create an approved property
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'approved',
        ]);
    }

    /**
     * Create a pending property
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }

    /**
     * Create a villa property
     */
    public function villa(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'villa',
            'title' => 'Villa '.fake()->word().' à '.fake()->city(),
            'price' => fake()->numberBetween(50000000, 200000000),
        ]);
    }

    /**
     * Create an apartment property
     */
    public function apartment(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'apartment',
            'title' => 'Appartement '.fake()->word().' à '.fake()->city(),
            'price' => fake()->numberBetween(10000000, 50000000),
        ]);
    }
}
