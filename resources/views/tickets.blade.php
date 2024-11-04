@extends('base.base')

@section('content')
<div class="container mx-auto my-8">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold mb-4">{{$flight_title}}</h1>
        <a href="{{ route('flights.index') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold hover:bg-indigo-700 text-white">Back</a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">No.</th>
                    <th class="px-4 py-2 border">Passenger Name</th>
                    <th class="px-4 py-2 border">Passenger Phone</th>
                    <th class="px-4 py-2 border">Seat Number</th>
                    <th class="px-4 py-2 border">Boarding</th>
                    <th class="px-4 py-2 border">Check-in Time</th>
                    <th class="px-4 py-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp 
                @foreach($tickets as $ticket)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border">{{ $no++ }}</td>
                    <td class="px-4 py-2 border">{{ $ticket->passenger_name }}</td>
                    <td class="px-4 py-2 border">{{ $ticket->passenger_phone }}</td>
                    <td class="px-4 py-2 border">{{ $ticket->seat_number }}</td>
                    <td class="px-4 py-2 border">{{ $ticket->is_boarding}}</td>
                    <td class="px-4 py-2 border">{{ $ticket->boarding_time }}</td>
                    <td class="px-4 py-2 border flex space-x-2">
                        @if (!$ticket->is_checked_in)
                        <form action="{{ route('ticket.checkin', $ticket->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white hover:bg-green-500">Check In</button>
                        </form>
                        <form action="{{ route('ticket.delete', $ticket->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white hover:bg-red-500">Delete</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
