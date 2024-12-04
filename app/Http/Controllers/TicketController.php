<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flight;
use App\Models\Ticket;
use Carbon\Carbon;

class TicketController extends Controller
{
    public function index() {
        $flights = Flight::all();
        return view('flights', ['flights' => $flights]);
    }

    public function show(Flight $flight) {
        $tickets = Ticket::where('flight_id', $flight->id)->get();
        return view('admin.tickets', ['tickets' => $tickets, 'flight_title' => $flight->flight_title]);
    }

    public function create(Flight $flight) {
        return view('pesan', ['flight' => $flight]);
    }

    public function insert(Request $request, Flight $flight) {
        $request->validate([
            'passenger_name' => 'required|max:100',
            'seat_number' => 'required|max:5',
            'passenger_phone' => 'required|max:15'
        ], [
            'passenger_name.required' => 'nama customer harus diisi',
            'passenger_name.max' => 'nama customer maksimal 100 karakter',
            'seat_number.required' => 'nomor kursi harus diisi',
            'seat_number.max' => 'nomor kursi maksimal 5 karakter',
            'passenger_phone.required' => 'nomor telepon harus diisi',
            'passenger_phone.max' => 'nomor telepon maksimal 15 karakter'
        ]);

        $ticket = new Ticket;
        $ticket->flight_id = $flight->id;
        $ticket->passenger_name = $request->passenger_name;
        $ticket->passenger_phone = $request->passenger_phone;
        $ticket->seat_number = $request->seat_number;
        $ticket->is_boarding = 0;
        $ticket->boarding_time = null;
        $ticket->save();

        return redirect('/flights')->with('success', 'data berhasil disimpan');
    }

    public function checkIn(Ticket $ticket){
        $ticket->is_boarding = 1;
        $ticket->boarding_time = Carbon::now();
        $ticket->save();

        return redirect('/flights')->with('success', 'data berhasil diupdate');
    }

    public function delete(Ticket $ticket){
        $ticket->delete();

        return redirect('/flights')->with('success', 'data berhasil dihapus');
    }

    public function store(Request $request) {
        $request->validate([
            'flight_code' => 'required|max:10',
            'origin' => 'required|max:100',
            'destination' => 'required|max:100',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date',
        ]);

        $flight = new Flight;
        $flight->flight_code = $request->flight_code;
        $flight->origin = $request->origin;
        $flight->destination = $request->destination;
        $flight->departure_time = $request->departure_time;
        $flight->arrival_time = $request->arrival_time;
        $flight->save();

        return redirect()->route('admin.dashboard')->with('success', 'Flight created successfully');
    }
}