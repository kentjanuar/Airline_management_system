@extends('base.baseAdmin')

@section('content')
<div class="container mx-auto my-10 flex justify-center">
    <div class="w-full max-w-md">
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 dark:bg-gray-800 dark:border-gray-700">
            <div class="mb-4">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Create Flight</h2>
            </div>

            <form class="space-y-6" action="{{ route('admin.flights.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2 dark:text-white" for="flight_code">
                        Flight Code
                    </label>
                    <input type="text" name="flight_code" id="flight_code" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-gray-50 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2 dark:text-white" for="origin">
                        Origin
                    </label>
                    <input type="text" name="origin" id="origin" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-gray-50 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2 dark:text-white" for="destination">
                        Destination
                    </label>
                    <input type="text" name="destination" id="destination" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-gray-50 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2 dark:text-white" for="departure_time">
                        Departure Time
                    </label>
                    <input type="datetime-local" name="departure_time" id="departure_time" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-gray-50 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2 dark:text-white" for="arrival_time">
                        Arrival Time
                    </label>
                    <input type="datetime-local" name="arrival_time" id="arrival_time" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-gray-50 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Create Flight
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection