@extends('admin.theme.default')

@section('content')

<div class="w-full mt-12 px-4 sm:px-6 lg:px-8"> {{-- Added consistent responsive padding and top margin --}}
    <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 dark:text-white flex items-center mb-6"> {{-- Enhanced header styling --}}
        <i class="fas fa-user-shield mr-3 text-indigo-600"></i> {{ __('Administrator Profile') }}
    </h1>
</div>

<div class="py-6 px-4 sm:px-6 lg:px-8"> {{-- Adjusted padding for main content area --}}
    <div class="max-w-7xl mx-auto space-y-8"> {{-- Increased space-y for more separation between sections --}}

        @include('admin.profile.partials.update-profile-information-form')

        @include('admin.profile.partials.update-password-form')

        @include('admin.profile.partials.delete-user-form')

    </div>
</div>

@endsection