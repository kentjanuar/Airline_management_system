<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        // Create a user for testing
        $this->user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'isAdmin' => false,
        ]);

        // Create an admin user for testing
        $this->admin = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('adminpassword'),
            'isAdmin' => true,
        ]);
    }

    public function test_login_with_valid_credentials()
    {
        $response = $this->post(route('login_post'), [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/flights');
        $this->assertAuthenticatedAs($this->user);
    }

    public function test_login_with_invalid_credentials()
    {
        $response = $this->post(route('login_post'), [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_admin_login_with_valid_credentials()
    {
        $response = $this->post(route('login_post'), [
            'email' => 'admin@example.com',
            'password' => 'adminpassword',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($this->admin);
    }

    public function test_login_empty_input_partitions()
    {
        // Empty email
        $response = $this->post(route('login_post'), [
            'email' => '',
            'password' => 'anypassword'
        ]);
        $response->assertSessionHasErrors('email');

        // Empty password
        $response = $this->post(route('login_post'), [
            'email' => 'test@example.com',
            'password' => ''
        ]);
        $response->assertSessionHasErrors('password');
    }
}