@extends('admin.theme.default')

@section('content')

<div class="w-full mt-12 px-4 sm:px-6 lg:px-8"> {{-- Added responsive padding --}}

    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6">
        <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 dark:text-white mb-4 sm:mb-0">
            <i class="fas fa-users mr-3 text-blue-600"></i> Registered User Accounts
        </h1>
        <div class="flex flex-col sm:flex-row gap-4 sm:gap-3 items-center">
            <div class="relative w-full sm:w-auto">
                <input id="myInput" class="pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150 ease-in-out w-full dark:bg-gray-700 dark:text-white" type="text" placeholder="Search users...">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
            </div>
            <a href="{{ route('admin.register') }}" class="w-full sm:w-auto px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-300 shadow-md">
                <i class="fas fa-user-plus mr-2"></i> Add New User
            </a>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row items-center justify-between mb-8 p-4 bg-white dark:bg-gray-800 rounded-xl shadow-md">
        <p class="text-lg text-gray-700 dark:text-gray-300 mb-2 sm:mb-0">
            Total Registered Users: <span class="font-bold text-gray-900 dark:text-white text-xl">{{ $users->total() }}</span> {{-- Use total() for paginated results --}}
        </p>
        {{-- You could add filter dropdowns here, e.g., by usertype or status --}}
        {{--
        <div class="flex items-center gap-2">
            <label for="usertype-filter" class="text-gray-600 dark:text-gray-400 text-sm">Filter by User Type:</label>
            <select id="usertype-filter" class="py-1 px-3 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white">
                <option value="">All</option>
                <option value="Admin">Admin</option>
                <option value="User">User</option>
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
                        <th scope="col" class="py-3 px-6 w-48">Name</th>
                        <th scope="col" class="py-3 px-6 w-auto">Email Address</th> {{-- Auto width --}}
                        <th scope="col" class="py-3 px-6 w-24">User Type</th> {{-- Slightly narrower --}}
                        <th scope="col" class="py-3 px-6 w-32">Created At</th>
                        <th scope="col" class="py-3 px-6 w-24">Status</th> {{-- Slightly narrower --}}
                        <th scope="col" class="py-3 px-6 w-32 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id='myTable'>

                    @if($users && $users->count())
                    @foreach($users as $index => $user)
                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                        <td class="py-3 px-6">{{ $loop->first ? $users->firstItem() + $index : $users->firstItem() + $index }}</td> {{-- Corrected index for pagination --}}
                        <td hidden class="py-3 px-6">{{ $user->id }}</td>
                        <td class="py-3 px-6 font-medium text-gray-900 dark:text-white">{{ $user->name }}</td>
                        <td class="py-3 px-6">{{ $user->email }}</td>
                        <td class="py-3 px-6">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                    @if($user->usertype === 'Admin') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                    @elseif($user->usertype === 'User') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif
                                ">
                                {{ ucfirst($user->usertype) }}
                            </span>
                        </td>
                        <td class="py-3 px-6 text-gray-700 dark:text-gray-300">{{ $user->created_at->format('M d, Y H:i A') }}</td>
                        <td class="py-3 px-6">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                    @if($user->status === 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @elseif($user->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                    @elseif($user->status === 'inactive') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif
                                ">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td class="py-3 px-6 text-center whitespace-nowrap"> {{-- Prevent wrapping for action buttons --}}
                            <a href="{{ route('admin.update_account', $user->id) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200 font-medium text-sm transition duration-150 ease-in-out mr-3">Edit</a>

                            <a href="#" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200 font-medium text-sm transition duration-150 ease-in-out delete-user-button"
                                data-form-id="delete-user-form-{{ $user->id }}">Delete</a>

                            <form id="delete-user-form-{{ $user->id }}" action="{{ route('admin.delete_user.destroy', $user->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                            </form>

                            <!-- <form action="{{ route('admin.delete_user.destroy', $user->id) }}" method="POST" class="inline-block delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200 font-medium text-sm transition duration-150 ease-in-out">
                                    Delete
                                </button>
                            </form> -->
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr class="bg-white dark:bg-gray-800">
                        <td colspan="8" class="text-center py-6 text-gray-600 dark:text-gray-400">No registered users found.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="py-4 px-6 border-t border-gray-200 dark:border-gray-700 flex justify-end"> {{-- Align pagination to the right --}}
            {{ $users->links('pagination::tailwind') }}
        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Live Search Functionality
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        
        // SweetAlert for Delete Confirmation (triggered by <a> tag)
        document.querySelectorAll('.delete-user-button').forEach(button => {
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