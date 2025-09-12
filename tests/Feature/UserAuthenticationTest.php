<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserAuthenticationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function user_can_register_with_valid_data()
    {
        $userData = [
            'first_name' => 'Jean',
            'last_name' => 'Dupont',
            'email' => 'jean@example.com',
            'phone' => '+237123456789',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'client',
        ];

        $response = $this->post('/register', $userData);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('users', [
            'email' => 'jean@example.com',
            'role' => 'client',
        ]);
    }

    /** @test */
    public function user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function user_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /** @test */
    public function wallet_is_created_when_user_registers()
    {
        $userData = [
            'first_name' => 'Marie',
            'last_name' => 'Martin',
            'email' => 'marie@example.com',
            'phone' => '+237987654321',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'investor',
        ];

        $this->post('/register', $userData);

        $user = User::where('email', 'marie@example.com')->first();
        $this->assertNotNull($user);
        $this->assertDatabaseHas('wallets', [
            'user_id' => $user->id,
            'balance' => 0,
        ]);
    }

    /** @test */
    public function user_can_logout()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    /** @test */
    public function user_can_register_as_admin()
    {
        $userData = [
            'first_name' => 'Test',
            'last_name' => 'Admin',
            'email' => 'testadmin@example.com',
            'phone' => '+2371234567890',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'admin',
        ];

        $response = $this->post('/register', $userData);
        $response->assertRedirect('/dashboard');

        $this->assertDatabaseHas('users', [
            'email' => 'testadmin@example.com',
            'role' => 'admin',
        ]);
    }

    /** @test */
    public function user_can_register_as_agent()
    {
        $userData = [
            'first_name' => 'Test',
            'last_name' => 'Agent',
            'email' => 'testagent@example.com',
            'phone' => '+2371234567891',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'agent',
        ];

        $response = $this->post('/register', $userData);
        $response->assertRedirect('/dashboard');

        $this->assertDatabaseHas('users', [
            'email' => 'testagent@example.com',
            'role' => 'agent',
        ]);
    }

    /** @test */
    public function user_can_register_as_client()
    {
        $userData = [
            'first_name' => 'Test',
            'last_name' => 'Client',
            'email' => 'testclient@example.com',
            'phone' => '+2371234567892',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'client',
        ];

        $response = $this->post('/register', $userData);
        $response->assertRedirect('/dashboard');

        $this->assertDatabaseHas('users', [
            'email' => 'testclient@example.com',
            'role' => 'client',
        ]);
    }
}
