@extends('admin.theme.default')

@section('content')

<div class="w-full mt-12 px-4 sm:px-6 lg:px-8"> {{-- Added responsive padding --}}

    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6">
        <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 dark:text-white mb-4 sm:mb-0">
            <i class="fas fa-list-alt mr-3 text-purple-600"></i> Latest User Reports
        </h1>
        <div class="relative w-full sm:w-auto">
            <input id="myInput" class="pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150 ease-in-out w-full dark:bg-gray-700 dark:text-white" type="text" placeholder="Search reports...">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row items-center justify-between mb-8 p-4 bg-white dark:bg-gray-800 rounded-xl shadow-md">
        <p class="text-lg text-gray-700 dark:text-gray-300 mb-2 sm:mb-0">
            Total Reports Submitted: <span class="font-bold text-gray-900 dark:text-white text-xl">{{ $reports->total() }}</span>
        </p>
        {{-- Optional: Add filter dropdowns here, e.g., by status --}}
        {{--
        <div class="flex items-center gap-2">
            <label for="status-filter" class="text-gray-600 dark:text-gray-400 text-sm">Filter by Status:</label>
            <select id="status-filter" class="py-1 px-3 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white">
                <option value="">All</option>
                <option value="pending">Pending</option>
                <option value="resolved">Resolved</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>
        --}}
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400 table-auto">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 uppercase font-semibold text-xs">
                    <tr>
                        <th scope="col" class="py-3 px-6 w-12">#</th>
                        <th hidden scope="col" class="py-3 px-6 w-0">ID</th>
                        <th scope="col" class="py-3 px-6 w-40">User Name</th>
                        <th scope="col" class="py-3 px-6 w-56">Title</th>
                        <th scope="col" class="py-3 px-6 w-auto">Description</th>
                        <th scope="col" class="py-3 px-6 w-24 text-center">Status</th>
                        <th scope="col" class="py-3 px-6 w-32">Submitted On</th>
                        <th scope="col" class="py-3 px-6 w-40 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id='myTableBody'> {{-- Changed ID to myTableBody for clarity with jQuery --}}
                    @forelse($reports as $index => $report)
                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                        <td class="py-3 px-6">
                            {{ $reports->firstItem() + $loop->index }} {{-- Correct index for pagination --}}
                        </td>
                        <th hidden scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $report->id }}
                        </th>
                        <td class="py-3 px-6 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            {{ $report->user->name ?? 'N/A' }}
                        </td>
                        <td class="py-3 px-6 text-gray-700 dark:text-gray-300">
                            {{ $report->title }}
                        </td>
                        <td class="py-3 px-6 text-gray-700 dark:text-gray-300">
                            <p class="line-clamp-2">{{ $report->description }}</p> {{-- Using line-clamp for description --}}
                        </td>
                        <td class="py-3 px-6 text-center">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                @if($report->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                @elseif($report->status === 'resolved') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @elseif($report->status === 'rejected') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif
                            ">
                                {{ ucfirst($report->status) }}
                            </span>
                        </td>
                        <td class="py-3 px-6 text-gray-700 dark:text-gray-300 whitespace-nowrap">
                            {{ $report->created_at->format('M d, Y H:i A') }}
                        </td>
                        <td class="py-3 px-6 text-center whitespace-nowrap">
                            <a href="{{ route('admin.reports.edit', $report->id) }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold text-white bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-800 rounded-md transition duration-150 ease-in-out shadow-sm mr-2">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <a href="{{ route('show_passenger_report', $report->id) }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 rounded-md transition duration-150 ease-in-out shadow-sm mr-2">
                                <i class="fas fa-eye mr-1"></i> View
                            </a>

                            <a href="#" class="inline-flex items-center px-4 py-2 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 rounded-md transition duration-150 ease-in-out shadow-sm delete-report-button"
                                data-form-id="delete-report-form-{{ $report->id }}">
                                <i class="fas fa-trash-alt mr-1"></i> Delete
                            </a>

                            <form id="delete-report-form-{{ $report->id }}" action="{{ route('delete.report', $report->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="report_id" value="{{ $report->id }}"> {{-- Changed to report_id for clarity --}}
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr class="bg-white dark:bg-gray-800">
                        <td colspan="8" class="text-center py-6 text-gray-600 dark:text-gray-400">No reports found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="py-4 px-6 border-t border-gray-200 dark:border-gray-700 flex justify-end">
            {{ $reports->links('pagination::tailwind') }}
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Moved jQuery to the end for better practice
    $(document).ready(function() {
        // Live Search Functionality
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            // Filter rows in the table body with ID 'myTableBody'
            $("#myTableBody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });

        // SweetAlert for Delete Confirmation (triggered by <a> tag)
        document.querySelectorAll('.delete-report-button').forEach(button => {
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

<!-- // SweetAlert for success/error messages (placed outside the event listeners) -->
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