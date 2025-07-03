@extends('admin.theme.default')

@section('content')

<div class="py-12 min-h-screen flex items-center justify-center">
    <div class="max-w-full w-full mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
            {{-- Header section for the form --}}
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 rounded-t-lg">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                    {{ __('Register New User') }}
                </h2>
                <p class="text-gray-600 dark:text-gray-400 text-sm">
                    {{ __('Fill in the details below to register a new user account.') }}
                </p>
            </div>

            {{-- Form Content Section --}}
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <form method="POST" action="{{ route('admin.register') }}" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div class="relative">
                        <label for="name" class="sr-only">{{ __('Name') }}</label>
                        <input
                            id="name"
                            class="appearance-none border pl-12 border-gray-300 dark:border-gray-600 shadow-sm focus:shadow-md focus:placeholder-gray-600 transition rounded-md w-full py-3 text-gray-800 dark:text-gray-200 leading-tight focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-900"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autofocus
                            autocomplete="name"
                            placeholder="Full Name"
                        />
                        <div class="absolute left-0 inset-y-0 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 ml-3 text-gray-400 dark:text-gray-500 p-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="relative">
                        <label for="email" class="sr-only">{{ __('Email') }}</label>
                        <input
                            id="email"
                            class="appearance-none border pl-12 border-gray-300 dark:border-gray-600 shadow-sm focus:shadow-md focus:placeholder-gray-600 transition rounded-md w-full py-3 text-gray-800 dark:text-gray-200 leading-tight focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-900"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="username"
                            placeholder="Email Address"
                        />
                        <div class="absolute left-0 inset-y-0 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 ml-3 text-gray-400 dark:text-gray-500 p-1" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="relative">
                        <label for="password" class="sr-only">{{ __('Password') }}</label>
                        <input
                            id="password"
                            class="appearance-none border pl-12 border-gray-300 dark:border-gray-600 shadow-sm focus:shadow-md focus:placeholder-gray-600 transition rounded-md w-full py-3 text-gray-800 dark:text-gray-200 leading-tight focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-900"
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
                            placeholder="Password"
                        />
                        <div class="absolute left-0 inset-y-0 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 ml-3 text-gray-400 dark:text-gray-500 p-1" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 2a5 5 0 00-5 5v2a2 2 0 00-2 2v5a2 2 0 002 2h10a2 2 0 002-2v-5a2 2 0 00-2-2H7V7a3 3 0 015.905-.75 1 1 0 001.937-.5A5.002 5.002 0 0010 2z" />
                            </svg>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="relative">
                        <label for="password_confirmation" class="sr-only">{{ __('Confirm Password') }}</label>
                        <input
                            id="password_confirmation"
                            class="appearance-none border pl-12 border-gray-300 dark:border-gray-600 shadow-sm focus:shadow-md focus:placeholder-gray-600 transition rounded-md w-full py-3 text-gray-800 dark:text-gray-200 leading-tight focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-900"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="Confirm Password"
                        />
                        <div class="absolute left-0 inset-y-0 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 ml-3 text-gray-400 dark:text-gray-500 p-1" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 2a5 5 0 00-5 5v2a2 2 0 00-2 2v5a2 2 0 002 2h10a2 2 0 002-2v-5a2 2 0 00-2-2H7V7a3 3 0 015.905-.75 1 1 0 001.937-.5A5.002 5.002 0 0010 2z" />
                            </svg>
                        </div>
                        @error('password_confirmation')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Usertype -->
                    <div>
                        <label for="usertype" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('User type') }}</label>
                        <select
                            name="usertype"
                            id="usertype"
                            class="mt-1 block w-full px-3 py-3 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-900 dark:text-gray-200"
                        >
                            <option value="passenger" {{ old('usertype') == 'passenger' ? 'selected' : '' }}>Passenger</option>
                            <option value="driver" {{ old('usertype') == 'driver' ? 'selected' : '' }}>Driver</option>
                            <option value="admin" {{ old('usertype') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('usertype')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Status') }}</label>
                        <select
                            name="status"
                            id="status"
                            class="mt-1 block w-full px-3 py-3 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-900 dark:text-gray-200"
                        >
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <button
                            type="submit"
                            class="w-full py-3 px-4 uppercase rounded-md bg-indigo-600 hover:bg-indigo-700 shadow-md hover:shadow-lg font-medium transition transform hover:-translate-y-0.5 text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                        >
                            Register
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
