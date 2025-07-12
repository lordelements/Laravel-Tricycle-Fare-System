@extends('admin.theme.default')

@section('content')

<div class="w-full mt-12 px-4 sm:px-6 lg:px-8"> {{-- Added responsive padding --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-4 sm:mb-0">
            <i class="fas fa-history mr-3 text-blue-600"></i> User Activity Logs {{-- Changed icon for relevance, added color --}}
        </h1>
        <div class="relative w-full sm:w-auto">
            <input id="myInput" class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150 ease-in-out w-full" type="text" placeholder="Search logs...">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden"> {{-- More prominent shadow and rounded corners --}}
        <div class="overflow-x-auto"> {{-- Table will scroll horizontally if content overflows --}}
            <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400 table-auto"> {{-- Added text-sm and dark mode text colors --}}
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 uppercase font-semibold text-xs"> {{-- Lighter header background, uppercase, smaller font for headers --}}
                    <tr>
                        <th scope="col" class="py-3 px-6 w-12">#</th>
                        <th hidden scope="col" class="py-3 px-6 w-0">ID</th>
                        <th scope="col" class="py-3 px-6 w-48">Name</th> {{-- Added widths for better table-auto management --}}
                        <th scope="col" class="py-3 px-6 w-64">Activity</th>
                        <th scope="col" class="py-3 px-6 w-32">User Type</th>
                        <th scope="col" class="py-3 px-6 w-48">Date</th>
                        <th scope="col" class="py-3 px-6 w-32 text-center">Actions</th> {{-- Centered actions for consistency --}}
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id='myTable'> {{-- Added subtle row dividers --}}
                    @if($auditTrails && $auditTrails->count())
                    @foreach($auditTrails as $index => $log)
                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 ease-in-out"> {{-- Improved hover state --}}
                        <td class="py-3 px-6">{{ $index + 1 }}</td> {{-- Increased padding for rows --}}
                        <td hidden class="py-3 px-6">{{ $log->id }}</td>
                        <td class="py-3 px-6 font-medium text-gray-900 dark:text-white">{{ $log->name }}</td> {{-- Emphasized name --}}
                        <td class="py-3 px-6 text-gray-700 dark:text-gray-300">
                            <p class="line-clamp-2">{{ $log->activity }}</p> {{-- Use line-clamp for long activity descriptions --}}
                        </td>
                        <td class="py-3 px-6">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                    {{ $log->usertype === 'Admin' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : '' }}
                                    {{ $log->usertype === 'User' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : '' }}
                                    {{-- Add more conditions for other user types if needed --}}
                                ">
                                {{ ucfirst($log->usertype) }}
                            </span>
                        </td>
                        <td class="py-3 px-6 text-gray-700 dark:text-gray-300">{{ \Carbon\Carbon::parse($log->date)->format('M d, Y H:i A') }}</td> {{-- Formatted date --}}
                        <td class="py-3 px-6 text-center">
                            {{-- Changed to a button inside a form for better semantics and SweetAlert integration --}}
                            <!-- <a href="#" class="text-red-500 hover:text-red-700 ml-2"
                                onclick="event.preventDefault(); document.getElementById('delete-form-{{ $log->id }}').submit();">Delete</a>

                            <form id="delete-form-{{ $log->id }}" action="{{ route('delete_logs', $log->id) }}" method="POST" class="inline-block delete-form">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="user_id" value="{{ $log->id }}">
                            </form> -->

                            <form action="{{ route('delete_logs', $log->id) }}" method="POST" class="inline-block delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200 font-medium text-sm transition duration-150 ease-in-out">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr class="bg-white dark:bg-gray-800">
                        <td colspan="7" class="text-center py-6 text-gray-600 dark:text-gray-400">No user activity logs found.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="py-4 px-6 border-t border-gray-200 dark:border-gray-700"> {{-- Added border for separation --}}
            {{ $auditTrails->links('pagination::tailwind') }} {{-- Use Tailwind pagination theme --}}
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> {{-- Make sure jQuery is loaded --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> {{-- SweetAlert2 CDN --}}
<script>
    $(document).ready(function() {
        // Live Search Functionality
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
        
        // SweetAlert for Delete Confirmation
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault();

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
                        this.submit();
                    }
                });
            });
        });

    });
</script>

<!-- Show success -->
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

<!-- Show error -->
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