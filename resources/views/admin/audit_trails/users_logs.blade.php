@extends('admin.theme.default')

@section('content')

<div class="w-full mt-12">
    <!-- Header Section -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-semibold text-gray-800">
            <i class="fas fa-users mr-3"></i> Users Activity Logs
        </h1>
        <input id="myInput" class="py-2 px-4 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-300" type="text" placeholder="Search by ID, Name, Address, Contact Number, etc.">
    </div>

    <!-- Users Activity Logs Table -->
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full bg-white table-auto">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-4 text-left text-sm font-semibold">#</th>
                    <th hidden class="py-3 px-4 text-left text-sm font-semibold">ID</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold">Name</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold">Activity</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold">User type</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold">Date</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700" id='myTable'>
                @if($auditTrails && $auditTrails->count())
                @foreach($auditTrails as $index => $log)
                <tr class="{{ $loop->even ? 'bg-gray-100' : '' }}">
                    <td class="py-2 px-4">{{ $index + 1 }}</td>
                    <td hidden class="py-2 px-4">{{ $log->id }}</td>
                    <td class="py-2 px-4">{{ $log->name }}</td>
                    <td class="py-2 px-4">{{ $log->activity }}</td>
                    <td class="py-2 px-4">{{ $log->usertype }}</td>
                    <td class="py-2 px-4">{{ $log->date }}</td>
                    <td class="py-2 px-4">
                        <!-- Action Buttons -->
                        <a href="#" class="text-red-500 hover:text-red-700 ml-2"
                            onclick="event.preventDefault(); document.getElementById('delete-form-{{ $log->id }}').submit();">Delete</a>

                        <form id="delete-form-{{ $log->id }}" action="{{ route('delete_logs', $log->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="user_id" value="{{ $log->id }}">
                        </form>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="7" class="text-center py-2 px-4">No users found.</td>
                </tr>
                @endif
            </tbody>
        </table>
        <div class="flex justify-between py-4">
            {{ $auditTrails->links() }} <!-- Pagination links -->
        </div>
    </div>
</div>

<!-- Search Function In Ajax -->
<script>
    $(document).ready(function() {
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>

@endsection