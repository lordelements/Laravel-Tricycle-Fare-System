<x-app-layout>
    {{-- This section remains unchanged as it's part of the layout and welcome message --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div
        class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __('Welcome!, :name', ['name' => Auth::user()->name]) }}
                </div>

            </div>
        </div>
    </div>


    <!-- Responsive wrapper for Trip History Table -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Updated main container for the trip requests history table --}}
            <div class="overflow-x-auto shadow-md rounded-lg">
                {{-- Header section for the trip requests table, matching the reports table header --}}
                <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 rounded-t-lg">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Trip Requests History') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                        {{ __('Here you can view and manage your past trip requests.') }}
                    </p>
                </div>

                {{-- Table container --}}
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">{{ __('#No Trip') }}</th>
                            <th scope="col" class="px-6 py-3">{{ __('Passenger Current Location') }}</th>
                            <th scope="col" class="px-6 py-3">{{ __('Pickup Destination') }}</th>
                            <th scope="col" class="px-6 py-3">{{ __('Fare Price') }}</th>
                            <th scope="col" class="px-6 py-3">{{ __('Created At') }}</th>
                            <th scope="col" class="px-6 py-3">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($tripRequests as $index => $trip)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $trip->pickup_location }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $trip->destination }}</td>
                            {{-- Formatted fare price with PHP currency --}}
                            <td class="px-6 py-4 whitespace-nowrap">₱{{ number_format($trip->estimated_price, 2) }}</td>
                            {{-- Formatted timestamp to match reports table --}}
                            <td class="px-6 py-4 whitespace-nowrap">{{ $trip->timestamp }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="" class="inline-flex items-center px-4 py-1 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-md"
                                    onclick="event.preventDefault(); document.getElementById('delete-form-{{ $trip->id }}').submit();">Delete</a>

                                <form id="delete-form-{{ $trip->id }}" action="{{ route('passenger.trip.delete', $trip->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="user_id" value="{{ $trip->id }}">
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            {{-- Changed colspan to 6 as one column was removed --}}
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">{{ __('No trip requests found.') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Leaflet CDN -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>


    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: "success",
                title: "Good job!",
                text: "{{ session('success') }}",
                confirmButtonText: 'OK',
            });
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: "error",
                title: "Error!",
                text: "{{ session('error') }}",
                confirmButtonText: 'OK',
            });
        });
    </script>
    @endif
</x-app-layout>