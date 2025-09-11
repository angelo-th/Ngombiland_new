<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

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
            'role' => 'client'
        ];

        $response = $this->post('/register', $userData);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('users', [
            'email' => 'jean@example.com',
            'role' => 'client'
        ]);
    }

    /** @test */
    public function user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123')
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function user_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123')
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword'
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
            'role' => 'investor'
        ];

        $this->post('/register', $userData);

        $user = User::where('email', 'marie@example.com')->first();
        $this->assertNotNull($user);
        $this->assertDatabaseHas('wallets', [
            'user_id' => $user->id,
            'balance' => 0
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
    public function user_role_validation_works()
    {
        $validRoles = ['admin', 'agent', 'client', 'proprietor', 'investor'];
        
        foreach ($validRoles as $role) {
            $userData = [
                'first_name' => 'Test',
                'last_name' => 'User',
                'email' => "test{$role}@example.com",
                'phone' => "+23712345678{$role}",
                'password' => 'password123',
                'password_confirmation' => 'password123',
                'role' => $role
            ];

            $response = $this->post('/register', $userData);
            $response->assertRedirect('/dashboard');
            
            $this->assertDatabaseHas('users', [
                'email' => "test{$role}@example.com",
                'role' => $role
            ]);
        }
    }
}
