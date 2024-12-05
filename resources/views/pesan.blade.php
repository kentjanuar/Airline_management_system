@extends('base.baseUser')

@section('content')

<form action="{{ route('ticket.insert', $flight) }}" method="POST" class="max-w-sm my-10 mx-auto">
    @csrf
    <input type="hidden" name="flight_id" value="{{ $flight->id }}">
    <div class="mb-5">
        <label for="passenger_name" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
        <div class="mt-2">
            <input type="text" name="passenger_name" id="passenger_name"  value="{{ old('passenger_name') }}" class="@error('passenger_name') is-invalid @enderror block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" required>
            @error('passenger_name')
                <div class="border border-red-500 text-red-500 text-xs italic ">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="mb-5">
        <label for="seat_number" class="block text-sm font-medium leading-6 text-gray-900">Seat</label>
        <div class="mt-2">
            <input type="text" name="seat_number" id="seat_number" value="{{ old('seat_number') }}" class="@error('seat_number') is-invalid @enderror block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" required>
            @error('seat_number')
                <div class="border border-red-500 text-red-500 text-xs italic ">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="mb-5">
        <label for="passenger_phone" class="block text-sm font-medium leading-6 text-gray-900">Phone</label>
        <div class="mt-2">
            <input type="text" name="passenger_phone" id="passenger_phone" value="{{ old('passenger_phone') }}" class="@error('passenger_phone') is-invalid @enderror block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" required>
            @error('passenger_phone')
                <div class="border border-red-500 text-red-500 text-xs italic ">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
</form>

@endsection
