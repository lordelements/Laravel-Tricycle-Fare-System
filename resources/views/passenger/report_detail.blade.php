<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Report Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg">
                {{-- Header for the report detail card --}}
                <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 rounded-t-lg">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                        {{ __('Report:') }} <span class="text-indigo-600 dark:text-indigo-400">{{ $report->title }}</span>
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">
                        {{ __('Submitted on:') }} <span class="font-medium">{{ $report->created_at->format('M d, Y H:i A') }}</span>
                    </p>
                </div>

                {{-- Report details content --}}
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-8">
                      
                        {{-- Status --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Status') }}:
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
                    </div>

                    {{-- Description --}}
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Description') }}:
                        </label>
                        <p class="mt-1 text-base text-gray-800 dark:text-gray-200 leading-relaxed p-2 bg-gray-50 dark:bg-gray-700 rounded-md">
                            {{ $report->description }}
                        </p>
                    </div>

                    {{-- Last Updated --}}
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Last Updated') }}:
                        </label>
                        <p class="mt-1 text-base text-gray-800 dark:text-gray-200">
                            <span class="font-medium">{{ $report->updated_at->format('M d, Y H:i A') }}</span>
                        </p>
                    </div>

                    {{-- Back button --}}
                    <div class="mt-8">
                        <a href="{{ url()->previous() }}" class="inline-flex items-center px-5 py-2.5 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-sm text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 active:bg-gray-400 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Back') }}
                        </a>
                    </div>
                </div>
            </div>
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
</x-app-layout>