@extends('admin.theme.default')

@section('content')

<div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 p-4 sm:p-0">
    <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-800 dark:text-white mb-4 sm:mb-0">
        <i class="fas fa-tachometer-alt mr-4 text-blue-600"></i> Tricycle Fare Management System
    </h1>
    {{-- You can add a subtle current date/time or an action button here if needed --}}
    <span class="text-lg text-gray-600 dark:text-gray-400 font-medium hidden md:block">
        {{ now()->format('F j, Y') }}
    </span>
</div>

<div class="relative overflow-hidden p-6 bg-gradient-to-br from-blue-600 to-blue-800 rounded-xl shadow-lg mb-8">
    <div class="relative z-10 flex flex-col sm:flex-row items-start sm:items-center justify-between">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-white mb-2">Welcome Back, Admin!</h2>
            <p class="text-blue-100 text-base sm:text-lg">Here’s a quick overview of your system's performance.</p>
        </div>
        <div class="mt-4 sm:mt-0 text-white text-opacity-75">
            <i class="fas fa-chart-line text-5xl sm:text-6xl"></i>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">

    {{-- Total Users Card --}}
    <a href="{{ route('admin.registeredUsers') }}" class="block">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 p-6 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-1">Total Users</h3>
                <p class="text-4xl font-bold text-blue-600 dark:text-blue-400">{{ $totalUsers ?? 0 }}</p>
            </div>
            <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-full">
                <i class="fas fa-users text-3xl text-blue-600 dark:text-blue-400"></i>
            </div>
        </div>
    </a>

    {{-- Total Admins Card --}}
    <a href="{{ route('admin.registeredUsers') }}" class="block"> {{-- Assuming registeredUsers route shows all users, including admins --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 p-6 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-1">Total Admins</h3>
                <p class="text-4xl font-bold text-green-600 dark:text-green-400">{{ $totalUsersAdmin ?? 0 }}</p>
            </div>
            <div class="p-3 bg-green-100 dark:bg-green-900 rounded-full">
                <i class="fas fa-user-shield text-3xl text-green-600 dark:text-green-400"></i>
            </div>
        </div>
    </a>

    {{-- Total User Activity Logs Card --}}
    <a href="{{ route('admin.showAuditTrails') }}" class="block">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 p-6 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-1">User Activity Logs</h3>
                <p class="text-4xl font-bold text-yellow-600 dark:text-yellow-400">{{ $totalUsersLogs ?? 0 }}</p>
            </div>
            <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-full">
                <i class="fas fa-history text-3xl text-yellow-600 dark:text-yellow-400"></i>
            </div>
        </div>
    </a>

    {{-- Total Reports Card --}}
    <a href="{{ route('admin.reports.table') }}" class="block">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 p-6 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-1">Total Reports</h3>
                <p class="text-4xl font-bold text-purple-600 dark:text-purple-400">{{ $tripRequestsCount ?? 0 }}</p>
            </div>
            <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-full">
                <i class="fas fa-file-alt text-3xl text-purple-600 dark:text-purple-400"></i>
            </div>
        </div>
    </a>

    {{-- Pending Reports Card --}}
    <a href="{{ route('admin.reports.table') }}?status=pending" class="block"> {{-- Link to reports table filtered by pending --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 p-6 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-1">Pending Reports</h3>
                <p class="text-4xl font-bold text-orange-600 dark:text-orange-400">{{ $pendingReportsCount ?? 0 }}</p>
            </div>
            <div class="p-3 bg-orange-100 dark:bg-orange-900 rounded-full">
                <i class="fas fa-exclamation-circle text-3xl text-orange-600 dark:text-orange-400"></i> {{-- Changed icon for 'pending' --}}
            </div>
        </div>
    </a>

    {{-- Resolved Reports Card --}}
    <a href="{{ route('admin.reports.table') }}?status=resolved" class="block"> {{-- Link to reports table filtered by resolved --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 p-6 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-1">Resolved Reports</h3>
                <p class="text-4xl font-bold text-teal-600 dark:text-teal-400">{{ $resolvedReportsCount ?? 0 }}</p>
            </div>
            <div class="p-3 bg-teal-100 dark:bg-teal-900 rounded-full">
                <i class="fas fa-check-circle text-3xl text-teal-600 dark:text-teal-400"></i>
            </div>
        </div>
    </a>

</div>


<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
            <i class="fas fa-chart-bar mr-3 text-blue-500"></i> Monthly Reports Overview
        </h3>
        <canvas id="chartOne" width="400" height="200"></canvas>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
            <i class="fas fa-chart-pie mr-3 text-green-500"></i> Report Status Distribution
        </h3>
        <canvas id="chartTwo" width="400" height="200"></canvas>
    </div>
</div>

@endsection