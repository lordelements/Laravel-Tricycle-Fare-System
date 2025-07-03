@extends('admin.theme.default')

@section('content')

<div class="w-full mt-12">

    <!-- Header Section -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">
            <i class="fas fa-list mr-2"></i> Latest Users Reports
        </h1>
        <input id="myInput" class="py-2 px-4 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-300 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" type="text" placeholder="Search by ID, Name, Title, Description, etc.">
    </div>

    <!-- Report History Table -->
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <div class="p-6 border-b border-gray-200 bg-white dark:bg-gray-800 dark:border-gray-700 sm:rounded-t-lg">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Your Report History</h2>
            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Below is a list of all reports you have submitted.</p>
        </div>


        <div class="bg-white rounded shadow overflow-auto">

            {{-- Display the total number of reports --}}
            <div class="p-6 flex items-center justify-between mb-6">
                <p class="text-lg text-gray-600">Total Reports: <span class="font-semibold text-gray-800">{{ $reports->total() }}</span></p>
            </div>

            <table id="myTable" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            #
                        </th>
                        <th hidden scope="col" class="px-6 py-3">
                            ID
                        </th>
                        {{-- Displaying User's Name from the related 'user' model --}}
                        <th scope="col" class="px-6 py-3">
                            User Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Title
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Description
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Submitted On
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Ensure $reports is not empty and is iterable --}}
                    @forelse($reports as $index => $report)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">
                            {{ $index + $reports->firstItem() }} {{-- Correct index for pagination --}}
                        </td>
                        <th hidden scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $report->id }}
                        </th>
                        {{-- Accessing user's name via the eager-loaded relationship --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $report->user->name ?? 'N/A' }} {{-- Use 'N/A' if user is somehow null --}}
                        </td>
                        <td class="px-6 py-4">
                            {{ $report->title }}
                        </td>
                        <td class="px-6 py-4">
                            <p class="line-clamp-2">{{ $report->description }}</p> {{-- Using line-clamp for description --}}
                        </td>
                        <td class="px-6 py-4">
                            <span class="relative inline-block px-3 py-1 font-semibold leading-tight rounded-full
                            {{ $report->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100' : '' }}
                            {{ $report->status === 'resolved' ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : '' }}
                            {{ $report->status === 'rejected' ? 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100' : '' }}
                        ">
                                {{ ucfirst($report->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            {{ $report->created_at->format('M d, Y H:i A') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('admin.reports.edit', $report->id) }}" class="inline-flex items-center px-4 py-1 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-md mr-2">Edit</a>
                            <a href="{{ route('show_passenger_report', $report->id) }}" class="inline-flex items-center px-4 py-1 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md">View</a>
                            <a href="" class="inline-flex items-center px-4 py-1 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-md"
                                onclick="event.preventDefault(); document.getElementById('delete-form-{{ $report->id }}').submit();">Delete</a>

                            <form id="delete-form-{{ $report->id }}" action="{{ route('delete.report', $report->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="user_id" value="{{ $report->id }}">
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td colspan="7" class="px-6 py-4 text-center text-gray-700 dark:text-gray-300">No reports submitted yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-6">
        {{ $reports->links() }} {{-- Pagination links --}}
    </div>
</div>

<!-- Search Function In Ajax -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> {{-- Added jQuery CDN --}}
<script>
    $(document).ready(function() {
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            // Filter rows in the table body with ID 'myTable'
            $("#myTable tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>

@endsection