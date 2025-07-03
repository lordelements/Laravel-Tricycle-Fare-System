@extends('admin.theme.default')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h1 class="text-3xl font-semibold text-gray-800 dark:text-white">
        <i class="fas fa-tachometer-alt mr-3"></i> Tricycle Faire System
    </h1>
</div>

<div class="flex items-center justify-between p-6 bg-white dark:bg-gray-800 rounded-lg shadow">
    <div>
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Welcome, Admin!</h2>
        <p class="text-gray-600 dark:text-gray-400">Here’s a quick overview of your dashboard.</p>
    </div>
    <div class="text-blue-500">
        <i class="fas fa-tachometer-alt text-4xl"></i>
    </div>
</div>

<div class="flex flex-wrap mt-6">
    <div class="w-full lg:w-1/3 pr-0 lg:pr-2 mb-6 lg:mb-0">
        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow">
            <i class="fas fa-users text-blue-500 text-3xl mb-3"></i> {{-- Added color to icon --}}
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white"><a href="{{ route('admin.registeredUsers')}}">Total Users</a></h3>
            {{-- Assuming $totalUsers is passed from the controller --}}
            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $totalUsers ?? 0 }}</p>
        </div>
    </div>
    <div class="w-full lg:w-1/3 px-0 lg:px-2 mb-6 lg:mb-0">
        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow">
            <i class="fas fa-user-clock text-yellow-500 text-3xl mb-3"></i> {{-- Example icon --}}
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white"><a href="{{ route('admin.showAuditTrails')}}">Total User Logs</a></h3> {{-- Changed "Users Logs" to "User Logs" for better grammar --}}
            <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400 mt-2">{{ $totalUsersLogs ?? 0 }}</p> {{-- This is hardcoded; you'd fetch it similarly --}}
        </div>
    </div>
    <div class="w-full lg:w-1/3 pl-0 lg:pl-2">
        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow">
            <i class="fas fa-user-shield text-green-500 text-3xl mb-3"></i> {{-- Example icon --}}
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white"><a href="{{ route('admin.registeredUsers')}}">Total Admins</a></h3>
            <p class="text-2xl font-bold text-green-600 dark:text-green-400 mt-2">{{ $totalUsersAdmin ?? 0 }}</p> {{-- This is hardcoded; you'd fetch it similarly --}}
        </div>
    </div>
</div>

<div class="flex flex-wrap mt-6">
    <div class="w-full lg:w-1/3 pr-0 lg:pr-2 mb-6 lg:mb-0">
        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow">
            <i class="fas fa-file-alt text-purple-500 text-3xl mb-3"></i> {{-- Example icon --}}
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white"><a href="{{ route('admin.reports.table')}}">Total Reports</a></h3>
            {{-- This variable is now passed from the controller --}}
            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $reportsCount ?? 0 }}</p>
        </div>
    </div>
    <div class="w-full lg:w-1/3 px-0 lg:px-2 mb-6 lg:mb-0">
        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow">
            <i class="fas fa-exclamation-triangle text-orange-500 text-3xl mb-3"></i> {{-- Example icon --}}
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Pending Reports</h3>
            {{-- Assuming $pendingReportsCount is passed from the controller --}}
            <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400 mt-2">{{ $pendingReportsCount ?? 0 }}</p>
        </div>
    </div>
    <div class="w-full lg:w-1/3 pl-0 lg:pl-2">
        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow">
            <i class="fas fa-check-circle text-teal-500 text-3xl mb-3"></i> {{-- Example icon --}}
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Resolved Reports</h3>
            {{-- Assuming $resolvedReportsCount is passed from the controller --}}
            <p class="text-2xl font-bold text-green-600 dark:text-green-400 mt-2">{{ $resolvedReportsCount ?? 0 }}</p>
        </div>
    </div>
</div>

<div class="flex flex-wrap mt-6">
    <div class="w-full lg:w-1/2 pr-0 lg:pr-2">
        <p class="text-xl pb-3 flex items-center">
            <i class="fas fa-plus mr-3"></i> Monthly Reports
        </p>
        <div class="p-6 bg-white">
            <canvas id="chartOne" width="400" height="200"></canvas>
        </div>
    </div>
    <div class="w-full lg:w-1/2 pl-0 lg:pl-2 mt-12 lg:mt-0">
        <p class="text-xl pb-3 flex items-center">
            <i class="fas fa-check mr-3"></i> Resolved Reports
        </p>
        <div class="p-6 bg-white">
            <canvas id="chartTwo" width="400" height="200"></canvas>
        </div>
    </div>
</div>


@endsection