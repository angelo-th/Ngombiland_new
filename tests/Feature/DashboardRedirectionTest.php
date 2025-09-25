<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardRedirectionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_user_is_redirected_to_admin_dashboard()
    {
        $user = User::factory()->create(['role' => 'admin']);
        
        $response = $this->actingAs($user)->get('/dashboard');
        
        $response->assertRedirect('/admin');
    }

    /** @test */
    public function agent_user_is_redirected_to_agent_dashboard()
    {
        $user = User::factory()->create(['role' => 'agent']);
        
        $response = $this->actingAs($user)->get('/dashboard');
        
        $response->assertStatus(200);
        $response->assertViewIs('dashboard.agent');
    }

    /** @test */
    public function proprietor_user_is_redirected_to_proprietor_dashboard()
    {
        $user = User::factory()->create(['role' => 'proprietor']);
        
        $response = $this->actingAs($user)->get('/dashboard');
        
        $response->assertStatus(200);
        $response->assertViewIs('dashboard.proprietor');
    }

    /** @test */
    public function investor_user_is_redirected_to_investor_dashboard()
    {
        $user = User::factory()->create(['role' => 'investor']);
        
        $response = $this->actingAs($user)->get('/dashboard');
        
        $response->assertStatus(200);
        $response->assertViewIs('dashboard.investor');
    }

    /** @test */
    public function client_user_is_redirected_to_client_dashboard()
    {
        $user = User::factory()->create(['role' => 'client']);
        
        $response = $this->actingAs($user)->get('/dashboard');
        
        $response->assertStatus(200);
        $response->assertViewIs('dashboard.client');
    }

    /** @test */
    public function admin_registration_redirects_to_admin_dashboard()
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
        $response->assertRedirect('/admin');
    }

    /** @test */
    public function agent_registration_redirects_to_agent_dashboard()
    {
        $userData = [
            'first_name' => 'Test',
            'last_name' => 'Agent',
            'email' => 'testagent@example.com',
            'phone' => '+2371234567890',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'agent',
        ];

        $response = $this->post('/register', $userData);
        $response->assertRedirect('/agent/dashboard');
    }

    /** @test */
    public function proprietor_registration_redirects_to_dashboard()
    {
        $userData = [
            'first_name' => 'Test',
            'last_name' => 'Proprietor',
            'email' => 'testproprietor@example.com',
            'phone' => '+2371234567890',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'proprietor',
        ];

        $response = $this->post('/register', $userData);
        $response->assertRedirect('/dashboard');
    }

    /** @test */
    public function investor_registration_redirects_to_dashboard()
    {
        $userData = [
            'first_name' => 'Test',
            'last_name' => 'Investor',
            'email' => 'testinvestor@example.com',
            'phone' => '+2371234567890',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'investor',
        ];

        $response = $this->post('/register', $userData);
        $response->assertRedirect('/dashboard');
    }

    /** @test */
    public function client_registration_redirects_to_dashboard()
    {
        $userData = [
            'first_name' => 'Test',
            'last_name' => 'Client',
            'email' => 'testclient@example.com',
            'phone' => '+2371234567890',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'client',
        ];

        $response = $this->post('/register', $userData);
        $response->assertRedirect('/dashboard');
    }
}
