@extends('admin.theme.default')

@section('content')

<div class="w-full mt-12 px-4 sm:px-6 lg:px-8"> {{-- Added consistent responsive padding --}}

    <div class="max-w-7xl mx-auto"> {{-- Max width for larger screens to give content room --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden"> {{-- Prominent shadow and rounded corners --}}

            {{-- Header for the report detail card --}}
            <div class="p-6 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white mb-2 flex items-center">
                    <i class="fas fa-file-alt mr-3 text-indigo-600"></i> {{ __('Report Details:') }} <span class="ml-2 text-indigo-600 dark:text-indigo-400">{{ $report->title }}</span>
                </h2>
                <p class="text-gray-600 dark:text-gray-400 text-sm">
                    {{ __('Submitted on:') }} <span class="font-medium text-gray-700 dark:text-gray-300">{{ $report->created_at->format('M d, Y \a\t h:i A') }}</span> {{-- Added "at" for better readability --}}
                </p>
            </div>

            {{-- Report details content --}}
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6"> {{-- Increased gap for more breathing room --}}

                    {{-- Report ID --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('Report ID') }}:
                        </label>
                        <p class="mt-1 text-lg font-bold text-gray-900 dark:text-gray-100 bg-gray-100 dark:bg-gray-700 p-3 rounded-md shadow-sm"> {{-- Larger font, bold, more padding, distinct background --}}
                            {{ $report->id }}
                        </p>
                    </div>

                    {{-- Submitted By (User Name) --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('Submitted By') }}:
                        </label>
                        <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100 bg-gray-100 dark:bg-gray-700 p-3 rounded-md shadow-sm"> {{-- Larger font, bold, more padding, distinct background --}}
                            {{ $report->user->name ?? 'Unknown User' }}
                        </p>
                    </div>

                    {{-- Status --}}
                    <div class="md:col-span-2"> {{-- Make status take full width on medium screens and up --}}
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('Current Status') }}:
                        </label>
                        <p class="mt-1">
                            <span class="inline-flex items-center px-4 py-1.5 text-base font-bold rounded-full shadow-sm
                                @if($report->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                                @elseif($report->status === 'resolved') bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                @elseif($report->status === 'rejected') bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100
                                @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif
                            ">
                                {{ ucfirst($report->status) }}
                            </span>
                        </p>
                    </div>

                </div>

                {{-- Description --}}
                <div class="mt-8"> {{-- Increased top margin for separation --}}
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        {{ __('Description') }}:
                    </label>
                    <div class="mt-1 text-base text-gray-800 dark:text-gray-200 leading-relaxed bg-gray-100 dark:bg-gray-700 p-4 rounded-md shadow-sm border border-gray-200 dark:border-gray-600"> {{-- More padding, border, and background for description --}}
                        {{ $report->description }}
                    </div>
                </div>

                {{-- Last Updated --}}
                <div class="mt-8"> {{-- Increased top margin --}}
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        {{ __('Last Updated') }}:
                    </label>
                    <p class="mt-1 text-base text-gray-800 dark:text-gray-200">
                        <span class="font-medium">{{ $report->updated_at->format('M d, Y \a\t h:i A') }}</span>
                    </p>
                </div>

                {{-- Action buttons --}}
                <div class="mt-10 flex flex-wrap gap-4 justify-end"> {{-- Use gap and justify-end, allow wrapping --}}
                    {{-- Back button --}}
                    <a href="{{ route('admin.reports.table') }}" class="inline-flex items-center px-6 py-2.5 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-sm text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 shadow-md">
                        <i class="fas fa-arrow-left mr-2"></i> {{ __('Back to Reports') }}
                    </a>
                    {{-- Edit button --}}
                    <a href="{{ route('admin.reports.edit', $report->id) }}" class="inline-flex items-center px-6 py-2.5 bg-green-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 shadow-md">
                        <i class="fas fa-pen mr-2"></i> {{ __('Edit Report Status') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection