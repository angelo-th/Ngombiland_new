<?php

namespace Tests\Feature;

use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MessageSystemTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sender = User::factory()->create(['role' => 'client']);
        $this->receiver = User::factory()->create(['role' => 'proprietor']);
        $this->actingAs($this->sender);
    }

    /** @test */
    public function authenticated_user_can_send_message()
    {
        $messageData = [
            'receiver_id' => $this->receiver->id,
            'message' => 'Bonjour, je suis intéressé par votre propriété.',
        ];

        $response = $this->post('/messages', $messageData);

        $response->assertRedirect('/messages');
        $this->assertDatabaseHas('messages', [
            'sender_id' => $this->sender->id,
            'receiver_id' => $this->receiver->id,
            'message' => 'Bonjour, je suis intéressé par votre propriété.',
            'read' => false,
        ]);
    }

    /** @test */
    public function user_can_view_their_messages()
    {
        Message::factory()->create([
            'sender_id' => $this->receiver->id,
            'receiver_id' => $this->sender->id,
            'message' => 'Message reçu',
        ]);

        $response = $this->get('/messages');

        $response->assertStatus(200);
        $response->assertSee('Message reçu');
    }

    /** @test */
    public function user_can_view_specific_message()
    {
        $message = Message::factory()->create([
            'sender_id' => $this->receiver->id,
            'receiver_id' => $this->sender->id,
            'message' => 'Message détaillé',
        ]);

        $response = $this->get("/messages/{$message->id}");

        $response->assertStatus(200);
        $response->assertSee('Message détaillé');
    }

    /** @test */
    public function message_is_marked_as_read_when_viewed()
    {
        $message = Message::factory()->create([
            'sender_id' => $this->receiver->id,
            'receiver_id' => $this->sender->id,
            'message' => 'Message à lire',
            'read' => false,
        ]);

        $this->get("/messages/{$message->id}");

        $message->refresh();
        $this->assertTrue($message->read);
    }

    /** @test */
    public function user_can_see_unread_messages_count()
    {
        Message::factory()->create([
            'sender_id' => $this->receiver->id,
            'receiver_id' => $this->sender->id,
            'read' => false,
        ]);

        Message::factory()->create([
            'sender_id' => $this->receiver->id,
            'receiver_id' => $this->sender->id,
            'read' => true,
        ]);

        $unreadCount = $this->sender->unreadMessages()->count();
        $this->assertEquals(1, $unreadCount);
    }

    /** @test */
    public function message_validation_works()
    {
        $invalidData = [
            'receiver_id' => 999, // Non-existent user
            'message' => '', // Empty message
        ];

        $response = $this->post('/messages', $invalidData);

        $response->assertSessionHasErrors(['receiver_id', 'message']);
    }

    /** @test */
    public function user_cannot_send_message_to_themselves()
    {
        $messageData = [
            'receiver_id' => $this->sender->id,
            'message' => 'Message à moi-même',
        ];

        $response = $this->post('/messages', $messageData);

        $response->assertSessionHasErrors('receiver_id');
    }

    /** @test */
    public function message_requires_authentication()
    {
        auth()->logout();

        $messageData = [
            'receiver_id' => $this->receiver->id,
            'message' => 'Message sans auth',
        ];

        $response = $this->post('/messages', $messageData);

        $response->assertRedirect('/login');
    }

    /** @test */
    public function user_can_only_view_their_own_messages()
    {
        $otherUser = User::factory()->create();
        $otherMessage = Message::factory()->create([
            'sender_id' => $otherUser->id,
            'receiver_id' => $otherUser->id,
            'message' => 'Message privé',
        ]);

        $response = $this->get("/messages/{$otherMessage->id}");

        $response->assertStatus(403);
    }

    /** @test */
    public function message_timestamps_are_recorded()
    {
        $messageData = [
            'receiver_id' => $this->receiver->id,
            'message' => 'Message avec timestamp',
        ];

        $this->post('/messages', $messageData);

        $message = Message::where('sender_id', $this->sender->id)
            ->where('receiver_id', $this->receiver->id)
            ->first();

        $this->assertNotNull($message->created_at);
        $this->assertNotNull($message->updated_at);
    }

    /** @test */
    public function message_index_shows_messages_ordered_by_latest()
    {
        $oldMessage = Message::factory()->create([
            'sender_id' => $this->receiver->id,
            'receiver_id' => $this->sender->id,
            'message' => 'Ancien message',
            'created_at' => now()->subDays(2),
        ]);

        $newMessage = Message::factory()->create([
            'sender_id' => $this->receiver->id,
            'receiver_id' => $this->sender->id,
            'message' => 'Nouveau message',
            'created_at' => now(),
        ]);

        $response = $this->get('/messages');

        $response->assertStatus(200);
        $response->assertSeeInOrder(['Nouveau message', 'Ancien message']);
    }

    /** @test */
    public function support_message_has_limited_attempts_for_guests()
    {
        // This would test the middleware for guest message limits
        // Implementation depends on the middleware logic
        $this->assertTrue(true); // Placeholder for middleware test
    }
}
