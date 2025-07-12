<x-app-layout>
    <div class="pb-12 pt-6 px-4 sm:px-6 lg:px-8"> {{-- Adjusted padding for main content area --}}
        <div class="max-w-7xl mx-auto"> {{-- Max width for larger screens to give content room --}}
            {{-- Updated main container for the trip requests history table --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden"> {{-- Prominent shadow, rounded corners, and hidden overflow for table --}}
                {{-- Header section for the trip requests table, matching the reports table header --}}
                <div class="p-6 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white flex items-center"> {{-- Increased font size, bold, and added icon --}}
                        <i class="fas fa-route mr-3 text-blue-600"></i> {{ __('Trip Requests History') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 text-base mt-2"> {{-- Increased font size and margin --}}
                        {{ __('Here you can view and manage your past trip requests.') }}
                    </p>
                </div>

                {{-- Table container --}}
                <div class="overflow-x-auto"> {{-- Ensures table is horizontally scrollable on small screens --}}
                    <table class="w-full text-base text-left rtl:text-right text-gray-700 dark:text-gray-300"> {{-- Increased base font size and adjusted text color --}}
                        <thead class="text-sm text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400"> {{-- Slightly lighter header background --}}
                            <tr>
                                <th scope="col" class="px-6 py-3 font-semibold">{{ __('# Trip') }}</th> {{-- Added font-semibold --}}
                                <th scope="col" class="px-6 py-3 font-semibold">{{ __('Passenger Location') }}</th> {{-- Changed label to be more concise --}}
                                <th scope="col" class="px-6 py-3 font-semibold">{{ __('Destination') }}</th>
                                <th scope="col" class="px-6 py-3 font-semibold">{{ __('Fare Price') }}</th>
                                <th scope="col" class="px-6 py-3 font-semibold">{{ __('Requested At') }}</th> {{-- Changed label for clarity --}}
                                <th scope="col" class="px-6 py-3 font-semibold text-center">{{ __('Actions') }}</th> {{-- Centered and pluralized --}}
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($tripRequests as $index => $trip)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150 ease-in-out"> {{-- Subtle hover effect --}}
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100 whitespace-nowrap">{{ $index + 1 }}</td> {{-- Added font-medium for emphasis --}}
                                <td class="px-6 py-4 whitespace-nowrap">{{ $trip->pickup_location }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $trip->destination }}</td>
                                {{-- Formatted fare price with PHP currency --}}
                                <td class="px-6 py-4 whitespace-nowrap font-semibold text-green-600 dark:text-green-400">₱{{ number_format($trip->estimated_price, 2) }}</td> {{-- Highlighted price --}}
                                {{-- Formatted timestamp to match reports table --}}
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-400 text-sm">{{ \Carbon\Carbon::parse($trip->timestamp)->format('M d, Y H:i A') }}</td> {{-- Ensure Carbon parsing and consistent format --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center"> {{-- Centered action button --}}
                                    <button type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition duration-150 ease-in-out"
                                        onclick="event.preventDefault(); confirmDelete('{{ $trip->id }}');"> {{-- Changed to a button and called confirmDelete function --}}
                                        <i class="fas fa-trash mr-2"></i> {{ __('Delete') }}
                                    </button>

                                    <form id="delete-form-{{ $trip->id }}" action="{{ route('passenger.trip.delete', $trip->id) }}" method="POST" class="hidden"> {{-- Hidden form --}}
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr class="bg-white dark:bg-gray-800">
                                <td colspan="6" class="px-6 py-6 text-center text-gray-500 dark:text-gray-400 text-lg"> {{-- Increased padding and text size --}}
                                    <i class="fas fa-info-circle mr-2"></i> {{ __('No trip requests found.') }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!-- pagination links -->
                    <div class="px-6 py-4">
                        {{ $tripRequests->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- Leaflet CDN -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // SweetAlert for delete confirmation
        function confirmDelete(tripId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this trip request!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + tripId).submit();
                }
            });
        }
    </script>

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