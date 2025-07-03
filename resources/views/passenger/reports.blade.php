<x-app-layout>

    <div class="container mx-auto p-4 sm:p-6 lg:p-8">

        <!-- Report Creation Modal -->
        <div id="reportModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-auto p-6 relative">
                <!-- Modal Close Button -->
                <button id="closeReportModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl font-bold">
                    &times;
                </button>

                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Submit a New Report</h2>

                <form method="POST" action="{{ route('store.reports') }}">
                    @csrf

                    <!-- Title -->
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Report Title</label>
                        <input id="title" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out sm:text-sm" type="text" name="title" value="{{ old('title') }}" required autofocus autocomplete="off" placeholder="e.g., Driver rude behavior, Tricycle broken down" />
                        @error('title')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description of the Problem</label>
                        <textarea id="description" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out sm:text-sm resize-y" name="description" rows="5" required placeholder="Provide details about the issue you encountered.">{{ old('description') }}</textarea>
                        @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-start">
                        <button type="submit" class="px-5 py-2  text-white-600 bg-blue-600 hover:bg-blue-700 rounded-md">
                            Submit Report
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Report History Table -->
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <div class="p-6 border-b border-gray-200 bg-white dark:bg-gray-800 dark:border-gray-700 sm:rounded-t-lg">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Your Report History</h2>
                <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Below is a list of all reports you have submitted.</p>

                <button id="openReportModal" class="px-6 py-3 mt-4 bg-red-600 text-green font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300 ease-in-out">
                    + Create New Report
                </button>
            </div>

            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            #
                        </th>
                        <th hidden scope="col" class="px-6 py-3">
                            ID
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
                    @if($reports && $reports->count())
                    @foreach($reports as $index => $report)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">
                            {{ $index + 1 }}
                        </td>
                        <th hidden scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $report->id }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $report->title }}
                        </td>
                        <td class="px-6 py-4">
                            <p class="line-clamp-2">{{ $report->description }}</p> {{-- Using line-clamp for description --}}
                        </td>
                        <td class="px-6 py-4">
                            <span class="relative inline-block px-3 py-1 font-semibold leading-tight">
                                <span aria-hidden="true" class="absolute inset-0 {{ $report->status === 'pending' ? 'bg-yellow-200' : ($report->status === 'resolved' ? 'bg-green-200' : 'bg-red-200') }} opacity-50 rounded-full"></span>
                                <span class="relative text-xs {{ $report->status === 'pending' ? 'text-yellow-900' : ($report->status === 'resolved' ? 'text-green-900' : 'text-red-900') }}">
                                    {{ ucfirst($report->status) }}
                                </span>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            {{ $report->created_at->format('M d, Y H:i A') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap"> {{-- Added whitespace-nowrap to keep action links on one line --}}
                            <a href="{{ route('reports.report_detail', $report->id) }}" class="inline-flex items-center px-4 py-1 text-sm font-medium text-white bg-sky-500/90 hover:bg-sky-600 rounded-md">View</a>
                        
                            <a href="" class="inline-flex items-center px-4 py-1 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-md"
                            onclick="event.preventDefault(); document.getElementById('delete-form-{{ $report->id }}').submit();">Delete</a>
                            
                            <form id="delete-form-{{ $report->id }}" action="{{ route('delete.report', $report->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="user_id" value="{{ $report->id }}">
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td colspan="7" class="px-6 py-4 text-center text-gray-700 dark:text-gray-300">No reports submitted yet.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>



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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const openModalBtn = document.getElementById('openReportModal');
            const closeModalBtn = document.getElementById('closeReportModal');
            const reportModal = document.getElementById('reportModal');

            // Function to open the modal
            openModalBtn.addEventListener('click', () => {
                reportModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Optional: Disable body scrolling when modal is open
            });

            // Function to close the modal
            closeModalBtn.addEventListener('click', () => {
                reportModal.classList.add('hidden');
                document.body.style.overflow = ''; // Optional: Re-enable body scrolling
            });

            // Close modal when clicking outside of it
            reportModal.addEventListener('click', (event) => {
                if (event.target === reportModal) {
                    reportModal.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            });

            // Close modal with Escape key
            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && !reportModal.classList.contains('hidden')) {
                    reportModal.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            });

            // If there are validation errors, ensure the modal re-opens automatically


        });
    </script>

</x-app-layout>