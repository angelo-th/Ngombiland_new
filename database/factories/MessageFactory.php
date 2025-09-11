<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $messages = [
            'Bonjour, je suis intéressé par votre propriété.',
            'Pouvez-vous me donner plus d\'informations sur ce bien ?',
            'Quel est le prix de vente exact ?',
            'Y a-t-il des frais supplémentaires ?',
            'Puis-je visiter le bien ?',
            'Merci pour votre réponse rapide.',
            'Je voudrais négocier le prix.',
            'Quand sera-t-il disponible ?',
            'Avez-vous d\'autres propriétés similaires ?',
            'Je suis prêt à faire une offre.',
        ];

        return [
            'sender_id' => User::factory(),
            'receiver_id' => User::factory(),
            'message' => fake()->randomElement($messages),
            'read' => fake()->boolean(30), // 30% chance of being read
        ];
    }

    /**
     * Create an unread message
     */
    public function unread(): static
    {
        return $this->state(fn (array $attributes) => [
            'read' => false,
        ]);
    }

    /**
     * Create a read message
     */
    public function read(): static
    {
        return $this->state(fn (array $attributes) => [
            'read' => true,
        ]);
    }

    /**
     * Create a recent message
     */
    public function recent(): static
    {
        return $this->state(fn (array $attributes) => [
            'created_at' => fake()->dateTimeBetween('-1 week', 'now'),
        ]);
    }

    /**
     * Create an old message
     */
    public function old(): static
    {
        return $this->state(fn (array $attributes) => [
            'created_at' => fake()->dateTimeBetween('-1 year', '-1 month'),
        ]);
    }
}
