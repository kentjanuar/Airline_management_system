<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Flight;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class TicketControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $flight;

    protected function setUp(): void
    {
        parent::setUp();
        $this->flight = Flight::factory()->create();
    }

    public function test_can_view_flights_index()
    {
        $response = $this->get('/flights');
        
        $response->assertStatus(200);
        $response->assertViewIs('flights');
        $response->assertViewHas('flights');
    }

    public function test_can_view_create_ticket_form()
    {
        $response = $this->get(route('flights.create', $this->flight));
        
        $response->assertStatus(200);
        $response->assertViewIs('pesan');
        $response->assertViewHas('flight');
    }

    public function test_can_create_ticket()
    {
        $ticketData = [
            'passenger_name' => 'John Doe',
            'passenger_phone' => '1234567890',
            'seat_number' => 'A1'
        ];

        $response = $this->post(route('ticket.insert', $this->flight), $ticketData);

        $response->assertStatus(302);
        $response->assertRedirect('/flights');
        $this->assertDatabaseHas('tickets', $ticketData);
    }

    // Boundary Testing
    public function test_passenger_name_max_length()
    {
        $ticketData = [
            'passenger_name' => str_repeat('a', 99), // Boundary value
            'passenger_phone' => '1234567890',
            'seat_number' => 'A1'
        ];

        $response = $this->post(route('ticket.insert', $this->flight), $ticketData);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('tickets', $ticketData);
    }

    public function test_passenger_name_exceeds_max_length()
    {
        $ticketData = [
            'passenger_name' => str_repeat('a', 101), // Exceeds boundary value
            'passenger_phone' => '1234567890',
            'seat_number' => 'A1'
        ];

        $response = $this->post(route('ticket.insert', $this->flight), $ticketData);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['passenger_name']);
    }

    // Equivalence Class Testing
    public function test_valid_passenger_phone()
    {
        $ticketData = [
            'passenger_name' => 'John Doe',
            'passenger_phone' => '1234567890', // Valid equivalence class
            'seat_number' => 'A1'
        ];

        $response = $this->post(route('ticket.insert', $this->flight), $ticketData);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('tickets', $ticketData);
    }

    public function test_invalid_passenger_phone()
    {
        $ticketData = [
            'passenger_name' => 'John Doe',
            'passenger_phone' => 'invalid_phone', // Invalid equivalence class
            'seat_number' => 'A1'
        ];

        $response = $this->post(route('ticket.insert', $this->flight), $ticketData);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['passenger_phone']);
    }


    // Add to existing AuthAndTicketTest class

public function test_registration_name_length_boundaries()
{
    // Valid boundary: 254 characters
    $validNameData = [
        'name' => str_repeat('A', 254),
        'email' => 'test255@example.com',
        'password' => 'ValidPass123!',
        'password_confirmation' => 'ValidPass123!'
    ];

    $response = $this->post(route('register'), $validNameData);
    $response->assertSessionHasNoErrors();

    // Invalid boundary: 256 characters
    $invalidNameData = [
        'name' => str_repeat('A', 256),
        'email' => 'test256@example.com',
        'password' => 'ValidPass123!',
        'password_confirmation' => 'ValidPass123!'
    ];

    $response = $this->post(route('register'), $invalidNameData);
    $response->assertSessionHasErrors(['name']);
}

public function test_registration_password_length_boundaries()
{
    // Invalid boundary: 7 characters (too short)
    $shortPasswordData = [
        'name' => 'John Doe',
        'email' => 'short@example.com',
        'password' => 'Short1!',
        'password_confirmation' => 'Short1!'
    ];

    $response = $this->post(route('register'), $shortPasswordData);
    $response->assertSessionHasErrors(['password']);

    // Valid boundary: 8 characters
    $validPasswordData = [
        'name' => 'John Doe',
        'email' => 'valid@example.com',
        'password' => 'Valid8!1',
        'password_confirmation' => 'Valid8!1'
    ];

    $response = $this->post(route('register'), $validPasswordData);
    $response->assertSessionHasNoErrors();
}

public function test_registration_email_validation()
{
    // Invalid email formats
    $invalidEmailFormats = [
        'invalid-email',
        'invalid@',
        '@invalid.com',
        'invalid@example',
    ];

    foreach ($invalidEmailFormats as $invalidEmail) {
        $invalidEmailData = [
            'name' => 'John Doe',
            'email' => $invalidEmail,
            'password' => 'ValidPass123!',
            'password_confirmation' => 'ValidPass123!'
        ];

        $response = $this->post(route('register'), $invalidEmailData);
        $response->assertSessionHasErrors(['email']);
    }

    // Valid email format
    $validEmailData = [
        'name' => 'John Doe',
        'email' => 'valid.email+test@example.com',
        'password' => 'ValidPass123!',
        'password_confirmation' => 'ValidPass123!'
    ];

    $response = $this->post(route('register'), $validEmailData);
    $response->assertSessionHasNoErrors();
}

public function test_login_email_length_boundaries()
{
    // Edge case: Very short email
    $shortEmail = 'a@b.c';
    $response = $this->post(route('login_auth'), [
        'email' => $shortEmail,
        'password' => 'anypassword'
    ]);
    $response->assertSessionHasNoErrors();

    // Edge case: Very long email (255 characters)
    $longEmail = str_repeat('a', 240) . '@example.com';
    $user = User::factory()->create([
        'email' => $longEmail,
        'password' => Hash::make('password')
    ]);

    $response = $this->post(route('login_auth'), [
        'email' => $longEmail,
        'password' => 'password'
    ]);
    $response->assertSessionHasNoErrors();
}

// Partition Testing for Login Scenarios
public function test_login_partitions()
{
    // Partition 1: Valid Admin Login
    $adminUser = User::factory()->create([
        'email' => 'admin@test.com',
        'password' => Hash::make('adminpass'),
        'isAdmin' => true
    ]);

    $response = $this->post(route('login_auth'), [
        'email' => 'admin@test.com',
        'password' => 'adminpass'
    ]);
    $response->assertRedirect('/admin');

    // Partition 2: Valid Regular User Login
    $regularUser = User::factory()->create([
        'email' => 'user@test.com',
        'password' => Hash::make('userpass'),
        'isAdmin' => false
    ]);

    $response = $this->post(route('login_auth'), [
        'email' => 'user@test.com',
        'password' => 'userpass'
    ]);
    $response->assertRedirect('/flights');
}

// Boundary Testing for Password
public function test_login_password_complexity()
{
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => Hash::make('short')
    ]);

    // Extremely short password
    $response = $this->post(route('login_auth'), [
        'email' => 'test@example.com',
        'password' => 'short'
    ]);
    $response->assertSessionHasNoErrors(); // Accepts short password

    // Very long password (255 characters)
    $longPassword = str_repeat('a', 255);
    $longUser = User::factory()->create([
        'email' => 'long@example.com',
        'password' => Hash::make($longPassword)
    ]);

    $response = $this->post(route('login_auth'), [
        'email' => 'long@example.com',
        'password' => $longPassword
    ]);
    $response->assertSessionHasNoErrors();
}

// Invalid Login Partitions
public function test_login_invalid_partitions()
{
    // Partition: Non-existent email
    $response = $this->post(route('login_auth'), [
        'email' => 'nonexistent@example.com',
        'password' => 'anypassword'
    ]);
    $response->assertSessionHasErrors('email');

    // Partition: Incorrect password
    $user = User::factory()->create([
        'email' => 'correct@example.com',
        'password' => Hash::make('correctpassword')
    ]);

    $response = $this->post(route('login_auth'), [
        'email' => 'correct@example.com',
        'password' => 'incorrectpassword'
    ]);
    $response->assertSessionHasErrors('email');
}

// Empty Input Partitions
public function test_login_empty_input_partitions()
{
    // Empty email
    $response = $this->post(route('login_auth'), [
        'email' => '',
        'password' => 'anypassword'
    ]);
    $response->assertSessionHasErrors('email');

    // Empty password
    $response = $this->post(route('login_auth'), [
        'email' => 'test@example.com',
        'password' => ''
    ]);
    $response->assertSessionHasErrors('password');
}

}