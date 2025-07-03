@extends('admin.theme.default')

@section('content')

<div class="py-12">
    <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg">
            {{-- Header for the edit report card --}}
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 rounded-t-lg">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                    {{ __('Edit Report Status') }}
                </h2>
                <p class="text-gray-600 dark:text-gray-400 text-sm">
                    {{ __('Adjust the status for report ID:') }}
                    <span class="font-medium text-indigo-600 dark:text-indigo-400">{{ $report->id }}</span>
                    {{ __('from') }}
                    <span class="font-medium text-indigo-600 dark:text-indigo-400">"{{ $report->title }}"</span>
                    {{ __('submitted by') }}
                    <span class="font-medium text-indigo-600 dark:text-indigo-400">{{ $report->user->name ?? 'N/A User' }}</span>.
                </p>
            </div>

            {{-- Edit Report Form --}}
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <form method="POST" action="{{ route('admin.reports.update', $report->id) }}" class="space-y-6">
                    @csrf
                    @method('PATCH') {{-- Use PATCH method for updates --}}

                    {{-- Report Title (Read-only) --}}
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Report Title') }}:
                        </label>
                        <input type="text" id="title" value="{{ $report->title }}" readonly
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-gray-100 dark:bg-gray-900 dark:text-gray-200 cursor-not-allowed"/>
                    </div>

                    {{-- Report Description (Read-only) --}}
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Description') }}:
                        </label>
                        <textarea id="description" rows="4" readonly
                                  class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-gray-100 dark:bg-gray-900 dark:text-gray-200 cursor-not-allowed resize-none">{{ $report->description }}</textarea>
                    </div>

                    {{-- Current Status (Read-only) --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Current Status') }}:
                        </label>
                        <p class="mt-1">
                            <span class="inline-flex items-center px-3 py-1 text-sm font-semibold rounded-full
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
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-900 dark:text-gray-200">
                            <option value="pending" {{ old('status', $report->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="resolved" {{ old('status', $report->status) == 'resolved' ? 'selected' : '' }}>Resolved</option>
                            <option value="rejected" {{ old('status', $report->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Form Actions --}}
                    <div class="flex items-center justify-end mt-6 space-x-3">
                        <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 active:bg-gray-400 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Update Report') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
