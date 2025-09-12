<?php

namespace Tests\Feature;

use App\Models\Investment;
use App\Models\Message;
use App\Models\Property;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IntegrationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function complete_user_journey_from_registration_to_investment()
    {
        // 1. User registration
        $userData = [
            'first_name' => 'Jean',
            'last_name' => 'Investor',
            'email' => 'jean@example.com',
            'phone' => '+237123456789',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'investor',
        ];

        $response = $this->post('/register', $userData);
        $response->assertRedirect('/dashboard');

        $user = User::where('email', 'jean@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('investor', $user->role);

        // 2. Wallet creation
        $this->assertDatabaseHas('wallets', [
            'user_id' => $user->id,
            'balance' => 0,
        ]);

        // 3. Wallet topup
        $this->actingAs($user);
        $topupResponse = $this->post('/wallet/topup', ['amount' => 500000]);
        $topupResponse->assertJson(['success' => true]);

        $wallet = $user->wallet;
        $this->assertEquals(500000, $wallet->balance);

        // 4. Property creation by proprietor
        $proprietor = User::factory()->create(['role' => 'proprietor']);
        $property = Property::factory()->create([
            'user_id' => $proprietor->id,
            'is_crowdfundable' => true,
            'expected_roi' => 15.0,
        ]);

        // 5. Investment in property
        $investmentResponse = $this->post("/crowdfunding/{$property->id}/invest", [
            'amount' => 100000,
        ]);

        $investmentResponse->assertRedirect();
        $investmentResponse->assertSessionHas('success');

        // 6. Verify investment was created
        $this->assertDatabaseHas('investments', [
            'user_id' => $user->id,
            'property_id' => $property->id,
            'amount' => 100000,
            'roi' => 15.0,
        ]);

        // 7. Verify wallet balance was deducted
        $wallet->refresh();
        $this->assertEquals(400000, $wallet->balance);

        // 8. Verify transaction was recorded
        $this->assertDatabaseHas('transactions', [
            'user_id' => $user->id,
            'type' => 'investment',
            'amount' => 100000,
            'status' => 'completed',
        ]);
    }

    /** @test */
    public function property_owner_can_manage_their_properties()
    {
        $owner = User::factory()->create(['role' => 'proprietor']);
        $this->actingAs($owner);

        // 1. Create property
        $propertyData = [
            'title' => 'Villa moderne à Douala',
            'description' => 'Belle villa de 4 chambres',
            'price' => 75000000,
            'location' => 'Douala, Cameroun',
            'latitude' => 4.0483,
            'longitude' => 9.7043,
            'type' => 'villa',
        ];

        $response = $this->post('/properties', $propertyData);
        $response->assertRedirect('/properties');

        $property = Property::where('title', 'Villa moderne à Douala')->first();
        $this->assertNotNull($property);
        $this->assertEquals('pending', $property->status);

        // 2. Update property
        $updateData = [
            'title' => 'Villa moderne à Douala - Mise à jour',
            'description' => 'Belle villa de 4 chambres - Mise à jour',
            'type' => 'villa',
            'price' => 80000000,
            'location' => 'Douala, Cameroun',
            'latitude' => 4.0483,
            'longitude' => 9.7043,
        ];

        $updateResponse = $this->put("/properties/{$property->id}", $updateData);
        $updateResponse->assertRedirect('/properties');

        $property->refresh();
        $this->assertEquals('Villa moderne à Douala - Mise à jour', $property->title);
        $this->assertEquals(80000000, $property->price);

        // 3. Delete property
        $deleteResponse = $this->delete("/properties/{$property->id}");
        $deleteResponse->assertRedirect('/properties');

        $this->assertDatabaseMissing('properties', ['id' => $property->id]);
    }

    /** @test */
    public function messaging_system_works_between_users()
    {
        $sender = User::factory()->create(['role' => 'client']);
        $receiver = User::factory()->create(['role' => 'proprietor']);
        $this->actingAs($sender);

        // 1. Send message
        $messageData = [
            'receiver_id' => $receiver->id,
            'message' => 'Bonjour, je suis intéressé par votre propriété.',
        ];

        $response = $this->post('/messages', $messageData);
        $response->assertRedirect('/messages');

        $this->assertDatabaseHas('messages', [
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'message' => 'Bonjour, je suis intéressé par votre propriété.',
            'read' => false,
        ]);

        // 2. Receiver views message
        $this->actingAs($receiver);
        $message = Message::where('receiver_id', $receiver->id)->first();

        $viewResponse = $this->get("/messages/{$message->id}");
        $viewResponse->assertStatus(200);
        $viewResponse->assertSee('Bonjour, je suis intéressé par votre propriété.');

        // 3. Message is marked as read
        $message->refresh();
        $this->assertTrue($message->read);
    }

    /** @test */
    public function admin_can_manage_platform()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        // 1. Admin can access admin dashboard
        $response = $this->get('/admin');
        $response->assertStatus(200);

        // 2. Admin can view users
        $usersResponse = $this->get('/admin/users');
        $usersResponse->assertStatus(200);

        // 3. Admin can view settings
        $settingsResponse = $this->get('/admin/settings');
        $settingsResponse->assertStatus(200);
    }

    /** @test */
    public function wallet_transactions_are_properly_tracked()
    {
        $user = User::factory()->create();
        $wallet = Wallet::factory()->create([
            'user_id' => $user->id,
            'balance' => 1000000,
        ]);
        $this->actingAs($user);

        // 1. Topup
        $topupResponse = $this->post('/wallet/topup', ['amount' => 200000]);
        $topupResponse->assertJson(['success' => true]);

        $this->assertDatabaseHas('transactions', [
            'user_id' => $user->id,
            'type' => 'topup',
            'amount' => 200000,
            'status' => 'completed',
        ]);

        // 2. Withdraw
        $withdrawResponse = $this->post('/wallet/withdraw', ['amount' => 150000]);
        $withdrawResponse->assertJson(['success' => true]);

        $this->assertDatabaseHas('transactions', [
            'user_id' => $user->id,
            'type' => 'withdraw',
            'amount' => 150000,
            'status' => 'completed',
        ]);

        // 3. Verify final balance
        $wallet->refresh();
        $expectedBalance = 1000000 + 200000 - 150000;
        $this->assertEquals($expectedBalance, $wallet->balance);
    }

    /** @test */
    public function crowdfunding_roi_calculation_works()
    {
        $property = Property::factory()->create([
            'is_crowdfundable' => true,
            'expected_roi' => 12.5,
        ]);

        $investor1 = User::factory()->create(['role' => 'investor']);
        $investor2 = User::factory()->create(['role' => 'investor']);

        Wallet::factory()->create([
            'user_id' => $investor1->id,
            'balance' => 1000000,
        ]);

        Wallet::factory()->create([
            'user_id' => $investor2->id,
            'balance' => 1000000,
        ]);

        // First investment
        $this->actingAs($investor1);
        $this->post("/crowdfunding/{$property->id}/invest", ['amount' => 200000]);

        // Second investment
        $this->actingAs($investor2);
        $this->post("/crowdfunding/{$property->id}/invest", ['amount' => 300000]);

        // Verify both investments have correct ROI
        $investment1 = Investment::where('user_id', $investor1->id)->first();
        $investment2 = Investment::where('user_id', $investor2->id)->first();

        $this->assertEquals(12.5, $investment1->roi);
        $this->assertEquals(12.5, $investment2->roi);

        // Verify total investment amount
        $totalInvestment = Investment::where('property_id', $property->id)->sum('amount');
        $this->assertEquals(500000, $totalInvestment);
    }

    /** @test */
    public function property_search_and_filtering_works()
    {
        // Create users first
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();

        // Create properties with different types and locations
        Property::factory()->create([
            'user_id' => $user1->id,
            'title' => 'Villa à Douala',
            'type' => 'villa',
            'price' => 50000000,
            'location' => 'Douala, Cameroun',
            'status' => 'approved',
        ]);

        Property::factory()->create([
            'user_id' => $user2->id,
            'title' => 'Appartement à Yaoundé',
            'type' => 'apartment',
            'price' => 25000000,
            'location' => 'Yaoundé, Cameroun',
            'status' => 'approved',
        ]);

        Property::factory()->create([
            'user_id' => $user3->id,
            'title' => 'Maison à Bafoussam',
            'type' => 'house',
            'price' => 15000000,
            'location' => 'Bafoussam, Cameroun',
            'status' => 'pending',
        ]);

        // Test public property listing (authenticated user)
        $user = User::factory()->create();
        $this->actingAs($user);
        
        $response = $this->get('/properties');
        $response->assertStatus(200);
        $response->assertSee('Villa à Douala');
        $response->assertSee('Appartement à Yaoundé');
        $response->assertSee('Maison à Bafoussam');
    }

    /** @test */
    public function user_roles_and_permissions_work_correctly()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $proprietor = User::factory()->create(['role' => 'proprietor']);
        $investor = User::factory()->create(['role' => 'investor']);
        $client = User::factory()->create(['role' => 'client']);

        // Test admin access
        $this->actingAs($admin);
        $this->get('/admin')->assertStatus(200);

        // Test proprietor can create properties
        $this->actingAs($proprietor);
        $propertyData = [
            'title' => 'Test Property',
            'description' => 'Test Description',
            'type' => 'house',
            'price' => 1000000,
            'location' => 'Test Location',
            'latitude' => 4.0483,
            'longitude' => 9.7043,
        ];
        $this->post('/properties', $propertyData)->assertRedirect('/properties');

        // Test investor can invest
        $this->actingAs($investor);
        $wallet = Wallet::factory()->create([
            'user_id' => $investor->id,
            'balance' => 500000,
        ]);
        $property = Property::factory()->create(['is_crowdfundable' => true]);
        $this->post("/crowdfunding/{$property->id}/invest", ['amount' => 100000])
            ->assertRedirect();

        // Test client can send messages
        $this->actingAs($client);
        $messageData = [
            'receiver_id' => $proprietor->id,
            'message' => 'Test message',
        ];
        $this->post('/messages', $messageData)->assertRedirect('/messages');
    }
}
