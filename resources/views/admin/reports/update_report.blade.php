@extends('admin.theme.default')

@section('content')

<div class="w-full mt-12 px-4 sm:px-6 lg:px-8"> {{-- Added consistent responsive padding --}}

    <div class="max-w-xl mx-auto"> {{-- Keeping max-width for the form card --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden"> {{-- Prominent shadow and rounded corners --}}

            {{-- Header for the edit report card --}}
            <div class="p-6 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white flex items-center mb-2">
                    <i class="fas fa-edit mr-3 text-blue-600"></i> {{ __('Edit Report Status') }}
                </h2>
                <p class="text-gray-600 dark:text-gray-400 text-sm">
                    {{ __('Adjust the status for report ID:') }}
                    <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $report->id }}</span>
                    {{ __('from') }}
                    <span class="font-semibold text-indigo-600 dark:text-indigo-400">"{{ $report->title }}"</span>
                    {{ __('submitted by') }}
                    <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $report->user->name ?? 'N/A User' }}</span>.
                </p>
            </div>

            {{-- Edit Report Form --}}
            <div class="p-6"> {{-- Consistent padding for the form content --}}
                <form method="POST" action="{{ route('admin.reports.update', $report->id) }}" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    {{-- Report Title (Read-only) --}}
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('Report Title') }}:
                        </label>
                        <input type="text" id="title" value="{{ $report->title }}" readonly
                               class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-gray-100 dark:bg-gray-900 text-gray-700 dark:text-gray-200 cursor-not-allowed"/>
                    </div>

                    {{-- Report Description (Read-only) --}}
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('Description') }}:
                        </label>
                        <textarea id="description" rows="4" readonly
                                  class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-gray-100 dark:bg-gray-900 text-gray-700 dark:text-gray-200 cursor-not-allowed resize-y">{{ $report->description }}</textarea> {{-- Changed resize-none to resize-y for vertical resizing --}}
                    </div>

                    {{-- Current Status (Read-only Badge) --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('Current Status') }}:
                        </label>
                        <p class="mt-1">
                            <span class="inline-flex items-center px-4 py-1.5 text-sm font-semibold rounded-full
                                {{ $report->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100' : '' }}
                                {{ $report->status === 'resolved' ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : '' }}
                                {{ $report->status === 'rejected' ? 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100' : '' }}
                                ">
                                {{ ucfirst($report->status) }}
                            </span>
                        </p>
                    </div>

                    {{-- New Status Selection --}}
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Change Status To') }}</label>
                        <select name="status" id="status"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-gray-200 transition duration-150 ease-in-out"> {{-- Enhanced focus, dark mode, and transition --}}
                            <option value="pending" {{ old('status', $report->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="resolved" {{ old('status', $report->status) == 'resolved' ? 'selected' : '' }}>Resolved</option>
                            <option value="rejected" {{ old('status', $report->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Form Actions --}}
                    <div class="flex items-center justify-end pt-4 space-x-3"> {{-- Added pt-4 for top spacing to buttons --}}
                        <a href="{{ url()->previous() }}" class="inline-flex items-center px-5 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-sm text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 shadow-sm">
                            <i class="fas fa-times mr-2"></i> {{ __('Cancel') }}
                        </a>
                        <button type="submit"
                                class="inline-flex items-center px-5 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 shadow-md">
                            <i class="fas fa-check-circle mr-2"></i> {{ __('Update Report') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- SweetAlert2 for success/error messages --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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