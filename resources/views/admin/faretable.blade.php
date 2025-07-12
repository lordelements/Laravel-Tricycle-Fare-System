@extends('admin.theme.default')

@section('content')

<div class="w-full mt-12 px-4 sm:px-6 lg:px-8"> {{-- Added responsive padding --}}

    <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 dark:text-white mb-6">
        <i class="fas fa-money-bill-wave mr-3 text-green-600"></i> Manage Fare Rates
    </h1>

    <div class="flex flex-col lg:flex-row gap-6"> {{-- Use flex-col and lg:flex-row for responsive stacking --}}

        <div class="w-full lg:w-1/2">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-6"> {{-- More prominent shadow, consistent padding --}}
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                    <i class="fas fa-plus-circle mr-3 text-blue-500"></i> Add New Fare Rate
                </h2>
                <form action="{{ route('admin.fare.store') }}" method="POST" class="space-y-5"> {{-- Added space-y for consistent vertical spacing --}}
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" for="base_fare">Base Fare (₱)</label>
                        <input class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150 ease-in-out dark:bg-gray-700 dark:text-white"
                            id="base_fare" name="base_fare" type="number" step="0.01" required placeholder="e.g. 30.00">
                        @error('base_fare')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" for="per_km_rate">Rate per Km (₱)</label>
                        <input class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150 ease-in-out dark:bg-gray-700 dark:text-white"
                            id="per_km_rate" name="per_km_rate" type="number" step="0.01" required placeholder="e.g. 10.00">
                        @error('per_km_rate')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" for="base_distance_km">Base Distance (km)</label>
                        <input class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150 ease-in-out dark:bg-gray-700 dark:text-white"
                            id="base_distance_km" name="base_distance_km" type="number" step="0.01" required placeholder="e.g. 1.00">
                        @error('base_distance_km')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" for="currency">Currency</label>
                        <input class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-white cursor-not-allowed" {{-- Styled as read-only --}}
                            id="currency" name="currency" type="text" maxlength="3" readonly value="PHP" required>
                        @error('currency')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-2"> {{-- Added padding top for button --}}
                        <button type="submit" class="w-full px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-300 shadow-md">
                            <i class="fas fa-save mr-2"></i> Save Fare Rate
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="w-full lg:w-1/2">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                    <i class="fas fa-table mr-3 text-purple-500"></i> Current Fare Rates
                </h2>

                <div class="flex items-center justify-between mb-6">
                    <p class="text-lg text-gray-700 dark:text-gray-300">
                        Fares Created: <span class="font-bold text-gray-900 dark:text-white text-xl">{{ $fares->count() }}</span>
                    </p>
                    {{-- If you had a search for the table, it would go here --}}
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700"> {{-- Added border for definition --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400 table-auto">
                            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 uppercase font-semibold text-xs">
                                <tr>
                                    <th scope="col" class="py-3 px-6 w-12">#</th>
                                    <th hidden scope="col" class="py-3 px-6 w-0">ID</th>
                                    <th scope="col" class="py-3 px-6 w-32">Base Fare (₱)</th>
                                    <th scope="col" class="py-3 px-6 w-32">Per Km (₱)</th>
                                    <th scope="col" class="py-3 px-6 w-40">Base Distance (km)</th>
                                    <th scope="col" class="py-3 px-6 w-32">Created</th>
                                    <th scope="col" class="py-3 px-6 w-24 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @if ($fares->isNotEmpty())
                                @foreach($fares as $index => $fare)
                                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                                    <td class="py-3 px-6">{{ $index + 1 }}</td>
                                    <td hidden class="py-3 px-6">{{ $fare->id }}</td>
                                    <td class="py-3 px-6 font-medium text-gray-900 dark:text-white">{{ number_format($fare->base_fare, 2) }}</td>
                                    <td class="py-3 px-6">{{ number_format($fare->per_km_rate, 2) }}</td>
                                    <td class="py-3 px-6">{{ number_format($fare->base_distance_km, 2) }}</td>
                                    <td class="py-3 px-6 text-gray-700 dark:text-gray-300">{{ $fare->created_at->format('M d, Y H:i A') }}</td>
                                    <td class="py-3 px-6 text-center whitespace-nowrap">
                                        <a href="#" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200 font-medium text-sm transition duration-150 ease-in-out delete-fare-button"
                                            data-form-id="delete-fare-form-{{ $fare->id }}">Delete</a>

                                        <form id="delete-fare-form-{{ $fare->id }}" action="{{ route('admin.delete_fare.destroy', $fare->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                            {{-- The 'user_id' input here might be a leftover from previous code. Consider changing it to 'fare_id' for clarity if your controller expects that. --}}
                                            <input type="hidden" name="fare_id" value="{{ $fare->id }}">
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr class="bg-white dark:bg-gray-800">
                                    <td colspan="7" class="text-center py-6 text-gray-600 dark:text-gray-400">No fare rates found.</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    {{-- Pagination for fares (if you paginate them) --}}
                    @if ($fares instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div class="py-4 px-6 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                        {{ $fares->links('pagination::tailwind') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // SweetAlert for Delete Confirmation (triggered by <a> tag)
        document.querySelectorAll('.delete-fare-button').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the default link behavior

                const formId = this.dataset.formId; // Get the ID of the associated form
                const form = document.getElementById(formId);

                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (form) {
                            form.submit(); // Submit the correct form if confirmed
                        }
                    }
                });
            });
        });

    });
</script>


@if(session('success'))
<script>
    Swal.fire({
        icon: "success",
        title: "Success!",
        text: "{{ session('success') }}",
        confirmButtonText: 'OK',
    });
</script>
@endif


@if(session('error'))
<script>
    Swal.fire({
        icon: "error",
        title: "Error!",
        text: "{{ session('error') }}",
        confirmButtonText: 'OK',
    });
</script>
@endif

@endsection