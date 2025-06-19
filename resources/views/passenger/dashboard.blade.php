<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 2000)"
        x-show="show"
        x-transition
        class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __('Welcome!, :name', ['name' => Auth::user()->name]) }}
                </div>

            </div>
        </div>
    </div>


    <!-- Responsive wrapper -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">{{ __('Trip Requests') }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                        {{ __('Here you can view and manage your trip requests.') }}
                    </p>


                    <!-- Add responsive wrapper -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('#No Trip') }}</th>
                                    <!-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('Trip ID') }}</th> -->
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('Passenger Current Location') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('Pickup Destination') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('Fare Price') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('Created At') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($tripRequests as $index => $trip)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $index + 1 }}</td>
                                    <td hidden class="px-6 py-4 whitespace-nowrap">{{ $trip->user_id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $trip->pickup_location }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $trip->destination }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $trip->estimated_price }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $trip->timestamp }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href=""  class="inline-flex items-center px-4 py-1 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-md"
                                            onclick="event.preventDefault(); document.getElementById('delete-form-{{ $trip->id }}').submit();">Delete</a>

                                        <form id="delete-form-{{ $trip->id }}" action="{{ route('passenger.trip.delete', $trip->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="user_id" value="{{ $trip->id }}">
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">{{ __('No trip requests found.') }}</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>