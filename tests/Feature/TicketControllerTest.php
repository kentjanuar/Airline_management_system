<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Flight;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Carbon\Carbon;

class TicketControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $flight;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a test flight
        $this->flight = Flight::factory()->create([
            'flight_code' => 'TEST1',
            'origin' => 'JFK',
            'destination' => 'LAX',
            'departure_time' => '2024-11-05',
            'arrival_time' => '2024-11-05'
        ]);
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

        $response->assertRedirect('/flights');
        $response->assertSessionHas('success', 'data berhasil disimpan');

        $this->assertDatabaseHas('tickets', [
            'flight_id' => $this->flight->id,
            'passenger_name' => 'John Doe',
            'passenger_phone' => '1234567890',
            'seat_number' => 'A1',
            'is_boarding' => 0,
        ]);
    }

    public function test_validates_required_fields_when_creating_ticket()
    {
        $response = $this->post(route('ticket.insert', $this->flight), []);

        $response->assertSessionHasErrors(['passenger_name', 'passenger_phone', 'seat_number']);
    }

    public function test_validates_field_lengths_when_creating_ticket()
    {
        $ticketData = [
            'passenger_name' => str_repeat('a', 101), // Exceeds 100 chars
            'passenger_phone' => str_repeat('1', 16), // Exceeds 15 chars
            'seat_number' => str_repeat('A', 4),      // Exceeds 3 chars
        ];

        $response = $this->post(route('ticket.insert', $this->flight), $ticketData);

        $response->assertSessionHasErrors([
            'passenger_name',
            'passenger_phone',
            'seat_number'
        ]);
    }

    public function test_can_view_tickets_for_flight()
    {
        $ticket = Ticket::factory()->create([
            'flight_id' => $this->flight->id,
            'passenger_name' => 'John Doe',
            'passenger_phone' => '1234567890',
            'seat_number' => 'A1',
        ]);

        $response = $this->get(route('flights.show', $this->flight));

        $response->assertStatus(200);
        $response->assertViewIs('tickets');
        $response->assertViewHas('tickets');
        $response->assertSee('John Doe');
    }

    public function test_can_check_in_ticket()
    {
        $ticket = Ticket::factory()->create([
            'flight_id' => $this->flight->id,
            'is_boarding' => 0,
            'boarding_time' => null
        ]);

        $response = $this->put(route('ticket.checkin', $ticket));

        $response->assertRedirect('/flights');
        $response->assertSessionHas('success', 'data berhasil diupdate');

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'is_boarding' => 1,
        ]);

        // Verify boarding time is set
        $updatedTicket = Ticket::find($ticket->id);
        $this->assertNotNull($updatedTicket->boarding_time);
    }

    public function test_can_delete_ticket()
    {
        $ticket = Ticket::factory()->create([
            'flight_id' => $this->flight->id
        ]);

        $response = $this->delete(route('ticket.delete', $ticket));

        $response->assertRedirect('/flights');
        $response->assertSessionHas('success', 'data berhasil dihapus');

        $this->assertDatabaseMissing('tickets', ['id' => $ticket->id]);
    }
}
