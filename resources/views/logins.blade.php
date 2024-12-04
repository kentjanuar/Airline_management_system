@extends('base.base')

@section('content')
<div class="container mx-auto my-10 flex justify-center">
    <div class="w-full max-w-md">
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 dark:bg-gray-800 dark:border-gray-700">
            <div class="mb-4">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Sign in</h2>
            </div>

            <form class="space-y-6" action="{{ route('login_post') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2 dark:text-white" for="email">
                        Your email
                    </label>
                    <input type="email" name="email" id="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-gray-50 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="name@company.com" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2 dark:text-white" for="password">
                        Your password
                    </label>
                    <input type="password" name="password" id="password" placeholder="••••••••" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-gray-50 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Login to your account
                    </button>
                </div>

                <div class="text-sm font-medium text-gray-500 dark:text-gray-300">
                    Not registered? <a href="{{ route('register') }}" class="text-blue-700 hover:underline dark:text-blue-500">Create account</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection