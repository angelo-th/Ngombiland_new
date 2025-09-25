<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CrowdfundingProject>
 */
class CrowdfundingProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $totalAmount = fake()->numberBetween(5000000, 50000000); // 5M à 50M FCFA
        $totalShares = fake()->numberBetween(100, 2000);
        $pricePerShare = $totalAmount / $totalShares;
        
        return [
            'user_id' => User::factory(),
            'property_id' => Property::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(3),
            'total_amount' => $totalAmount,
            'amount_raised' => fake()->numberBetween(0, $totalAmount),
            'total_shares' => $totalShares,
            'shares_sold' => fake()->numberBetween(0, $totalShares),
            'price_per_share' => $pricePerShare,
            'expected_roi' => fake()->randomFloat(2, 8, 25),
            'funding_deadline' => fake()->dateTimeBetween('now', '+6 months'),
            'status' => fake()->randomElement(['draft', 'active', 'funded', 'cancelled']),
            'images' => [
                'crowdfunding_'.fake()->uuid().'.jpg',
                'crowdfunding_'.fake()->uuid().'.jpg',
            ],
            'management_fee' => fake()->randomFloat(2, 2, 10),
        ];
    }

    /**
     * Create an active project
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
            'funding_deadline' => fake()->dateTimeBetween('+1 week', '+6 months'),
        ]);
    }

    /**
     * Create a funded project
     */
    public function funded(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'funded',
                'amount_raised' => $attributes['total_amount'],
                'shares_sold' => $attributes['total_shares'],
            ];
        });
    }
}
