@extends('base.base')

@section('content')

@if(session('success'))
    <div id="success-alert" class="fixed mx-auto mt-4 w-1/3 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-md" role="alert">
        <div class="flex justify-between items-center">
            <span>{{ session('success') }}</span>
            <button onclick="document.getElementById('success-alert').style.display='none'" class="text-green-700 hover:text-green-900 font-bold ml-4">
                &times;
            </button>
        </div>
    </div>
@endif


<div class="mx-auto my-4 container grid gap-6 grid-cols-3">
    @foreach ($flights as $flight)
    <div class="bg-gray-800 shadow-lg rounded-lg overflow-hidden">
        <div class="p-6">
            <p class="text-2xl font-semibold text-white">{{ $flight['flight_code'] }}</p>
            <label class="block text-gray-400">Departure</label>


            <p class="text-sm text-gray-300">{{ $flight['departure_time'] }}</p>
            <label class="block text-gray-400">Arrival</label>
            <p class="text-sm text-gray-300">{{ $flight['arrival_time'] }}</p>
        </div>
        <div class="flex justify-between p-4">
            <a href="{{route('flights.create', $flight)}}" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold hover:bg-indigo-700 text-white">Book Ticket</a>
        </div>
    </div>
    @endforeach
</div>




@endsection