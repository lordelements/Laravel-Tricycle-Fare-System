@extends('admin.theme.default')

@section('content')

<div class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-md">
    <form method="POST" action="{{ route('admin.update', $user->id) }}">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
            <input id="name" class="block mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500" type="text" name="name" value="{{ $user->name }}" required autofocus autocomplete="name" />
            @error('name')
                <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
            <input id="email" class="block mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500" type="email" name="email" value="{{ $user->email }}" required autocomplete="username" />
            @error('email')
                <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
            @enderror
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
            <input id="password" class="block mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500" type="password" name="password" autocomplete="new-password" />
            @error('password')
                <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">{{ __('Confirm Password') }}</label>
            <input id="password_confirmation" class="block mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500" type="password" name="password_confirmation" autocomplete="new-password" />
            @error('password_confirmation')
                <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
            @enderror
        </div>

        <!-- Usertype -->
        <div class="mt-4">
            <label for="usertype" class="block text-sm font-medium text-gray-700">{{ __('User  type') }}</label>
            <select name="usertype" id="usertype" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <option value="passenger" {{ $user->usertype == 'passenger' ? 'selected' : '' }}>Passenger</option>
                <option value="driver" {{ $user->usertype == 'driver' ? 'selected' : '' }}>Driver</option>
                <option value="admin" {{ $user->usertype == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            @error('usertype')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="ml-4 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Update
            </button>
        </div>
    </form>
</div>

@endsection