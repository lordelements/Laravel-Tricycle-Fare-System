<x-app-layout>
    {{-- This section remains unchanged as it's part of the layout and welcome message --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 px-4 sm:px-6 lg:px-8"> {{-- Added consistent responsive padding --}}
        <div class="max-w-7xl mx-auto"> {{-- Max width for larger screens --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-indigo-600 to-purple-800 text-white rounded-xl shadow-2xl p-8 mb-8 animate-fade-in">
                {{-- Subtle background pattern for visual interest --}}
                <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiB2aWV3Qm94PSIwIDAgMTIwMCAxMjAwIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxwYXRoIGZpbGw9IiNmZmZmZmYiIGQ9Ik0wIDBoMTIwMHYxMjAwSDBWMHoiLz48cGF0aCBmaWxsPSIjYmNkMWQ0IiBkPSJNMCA1OTguNzQ2YzIuNzI1LTIuNDQxIDUuNDUtNC44ODMgOC4xNzYtNy4zMjRjMjIuNDg1LTIwLjE2NiA0NC45Ny00MC4zMzMgNjcuNDU1LTYwLjQ5OWM0NC45Ny00MC4zMzMgODkuOTQtODAuNjY1IDEzNC45MS0xMjAuOTk4YzQ0Ljk3LTQwLjMzMyA4OS45NC04MC42NjUgMTM0LjkxLTEyMC45OThjNDQuOTctNDAuMzMzIDg5Ljk0LTgwLjY2NSAxMzQuOTEtMTIwLjk5OGM0NC45Ny00MC4zMzMgODkuOTQtODAuNjY1IDEzNC45MS0xMjAuOTk4YzQ0Ljk3LTQwLjMzMyA4OS45NC04MC42NjUgMTM0LjkxLTEyMC45OThjNDQuOTctNDAuMzMzIDg5Ljk0LTgwLjY2NSAxMzQuOTEtMTIwLjk5OGM0NC45Ny00MC4zMzMgODkuOTQtODAuNjY1IDEzNC45MS0xMjAuOTk4YzQ0Ljk3LTQwLjMzMyA4OS45NC04MC42NjUgMTM0LjkxLTEyMC45OThjNDQuOTctNDAuMzMzIDg5Ljk0LTgwLjY2NSAxMzQuOTEtMTIwLjk5OGM0NC45Ny00MC4zMzMgODkuOTQtODAuNjY1IDEzNC45MS0xMjAuOTk4YzQuMDQ3LTMuNjMyIDguMDk0LTcuMjY1IDEyLjE0MS0xMC44OTdWMjQ2LjI2NGMwIDY0LjcyNiAwIDEyOS40NTIgMCAxOTQuMTc4YzAgNjQuNzI2IDAgMTI5LjQ1MiAwIDE5NC4xNzhjMCA2NC43MjYgMCAxMjkuNDUyIDAgMTk0LjE3OGMwIDY0LjcyNiAwIDEyOS40NTIgMCAxOTQuMTc4YzAgNjQuNzI2IDAgMTI5LjQ1MiAwIDE5NC4xNzhjMCA2NC43MjYgMCAxMjkuNDUyIDAgMTk0LjE3OGMwIDcuMjY1IDAgMTQuNTMtMCAyMS43OTVjLTIuNzI1IDIuNDQxLTUuNDUgNC44ODMtOC4xNzYgNy4zMjRjLTIyLjQ4NSAyMC4xNjYtNDQuOTcgNDAuMzMzLTY3LjQ1NSA2MC40OTljLTQ0Ljk3IDQwLjMzMy04OS45NCA4MC42NjUtMTM0LjkxIDEyMC45OThjLTQ0Ljk3IDQwLjMzMy04OS45NCA4MC42NjUtMTM0LjkxIDEyMC45OThjLTQ0Ljk3IDQwLjMzMy04OS45NCA4MC42NjUtMTM0LjkxIDEyMC45OThjLTQ0Ljk3IDQwLjMzMy04OS45NCA4MC42NjUtMTM0LjkxIDEyMC45OThjLTQ0Ljk3IDQwLjMzMy04OS45NCA4MC42NjUtMTM0LjkxIDEyMC45OThjLTQ0Ljk3IDQwLjMzMy04OS45NCA4MC42NjUtMTM0LjkxIDEyMC45OThjLTQ0Ljk3IDQwLjMzMy04OS45NCA4MC42NjUtMTM0LjkxIDEyMC45OThjLTQ0Ljk3IDQwLjMzMy04OS45NCA4MC42NjUtMTM0LjkxIDEyMC45OThjLTQuMDQ3IDMuNjMyLTguMDk0IDcuMjY1LTEyLjE0MSAxMC44OTdWMTA2NS40MjZjMCAtNjQuNzI2IDAtMTI5LjQ1MiAwLTE5NC4xNzhjMC02NC43MjYgMC0xMjkuNDUyIDAtMTk0LjE3OGMwLTY0LjcyNiAwLTEyOS40NTIgMC0xOTQuMTc4Yy0uMDAxLTY0LjcyNiAwLTEyOS40NTIgMC0xOTQuMTc4Yy0uMDAxLTY0LjcyNiAwLTEyOS40NTIgMC0xOTQuMTc4Yy0uMDAxLTcuMjY2IDAtMTQuNTMxIDAtMjEuNzk3eiIvPjwvc3ZnPg=='); background-size: cover; background-position: center;"></div>
                <div class="relative z-10 flex flex-col sm:flex-row items-start sm:items-center justify-between">
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-extrabold mb-2 leading-tight">
                            {{ __('Hello, :name!', ['name' => Auth::user()->name]) }}
                        </h1>
                        <p class="text-indigo-100 text-base sm:text-lg opacity-90">
                            {{ __('Welcome to your personalized passenger dashboard. Here’s a quick overview of your activities.') }}
                        </p>
                    </div>
                    <div class="mt-6 sm:mt-0 text-white text-opacity-80">
                        <i class="fas fa-user-circle text-6xl sm:text-7xl"></i>
                    </div>
                </div>
            </div>

            
        <!-- Key Metrics Section -->
        <div class="mb-8">
            <h3 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white flex items-center mb-6">
                <i class="fas fa-tachometer-alt mr-3 text-blue-600"></i> {{ __('Your Activity Overview') }}
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Total Reports Card --}}
                <a href="{{ route('passenger.reports') }}" class="block transform hover:scale-103 transition-transform duration-200 ease-in-out">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg ring-1 ring-gray-100 dark:ring-gray-700 p-6 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-1">Your Total Reports</h3>
                            <p class="text-4xl font-bold text-purple-600 dark:text-purple-400">{{ $reportsCount ?? 0 }}</p>
                        </div>
                        <div class="p-4 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center">
                            <i class="fas fa-file-alt text-3xl text-purple-600 dark:text-purple-400"></i>
                        </div>
                    </div>
                </a>

                {{-- Total Trip Requests Card --}}
                <a href="{{ route('triprequest_history') }}" class="block transform hover:scale-103 transition-transform duration-200 ease-in-out">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg ring-1 ring-gray-100 dark:ring-gray-700 p-6 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-1">Your Total Trip Requests</h3>
                            <p class="text-4xl font-bold text-blue-600 dark:text-blue-400">{{ $tripRequestsCount ?? 0 }}</p>
                        </div>
                        <div class="p-4 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                            <i class="fas fa-route text-3xl text-blue-600 dark:text-blue-400"></i>
                        </div>
                    </div>
                </a>

            </div>
        </div>

        </div>
    </div>

</x-app-layout>