<aside class="relative bg-gradient-to-br from-blue-800 to-indigo-900 h-screen w-64 hidden sm:block shadow-2xl">
    <div class="p-6 border-b border-blue-700">
        <a href="{{ route('admin.dashboard') }}" class="text-white text-3xl font-extrabold tracking-wide uppercase hover:text-blue-200 transition duration-300 ease-in-out">
            Admin Panel
        </a>
    </div>
    <nav class="text-white text-base font-semibold pt-3 space-y-2">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center text-white py-3 pl-6 pr-4 rounded-lg mx-3 transition-colors duration-200 ease-in-out
            {{ Request::routeIs('admin.dashboard') ? 'bg-blue-700 shadow-md' : 'hover:bg-blue-700/50' }}
            ">
            <i class="fas fa-tachometer-alt mr-4 text-lg"></i>
            Dashboard
        </a>
        <a href="{{ route('admin.faretable') }}" class="flex items-center text-white py-3 pl-6 pr-4 rounded-lg mx-3 transition-colors duration-200 ease-in-out
            {{ Request::routeIs('admin.faretable') ? 'bg-blue-700 shadow-md' : 'hover:bg-blue-700/50' }}
            ">
            <i class="fas fa-money-bill-alt mr-4 text-lg"></i> {{-- Changed icon for relevance --}}
            Manage Fare Rates
        </a>
        <a href="{{ route('admin.registeredUsers') }}" class="flex items-center text-white py-3 pl-6 pr-4 rounded-lg mx-3 transition-colors duration-200 ease-in-out
            {{ Request::routeIs('admin.registeredUsers') ? 'bg-blue-700 shadow-md' : 'hover:bg-blue-700/50' }}
            ">
            <i class="fas fa-users mr-4 text-lg"></i>
            Registered Users
        </a>
        <a href="{{ route('admin.showAuditTrails') }}" class="flex items-center text-white py-3 pl-6 pr-4 rounded-lg mx-3 transition-colors duration-200 ease-in-out
            {{ Request::routeIs('admin.showAuditTrails') ? 'bg-blue-700 shadow-md' : 'hover:bg-blue-700/50' }}
            ">
            <i class="fas fa-history mr-4 text-lg"></i> {{-- Changed icon for relevance --}}
            User Activity Logs
        </a>
        <a href="{{ route('admin.reports.table') }}" class="flex items-center text-white py-3 pl-6 pr-4 rounded-lg mx-3 transition-colors duration-200 ease-in-out
            {{ Request::routeIs('admin.reports.table') ? 'bg-blue-700 shadow-md' : 'hover:bg-blue-700/50' }}
            ">
            <i class="fas fa-exclamation-triangle mr-4 text-lg"></i> {{-- Changed icon for relevance --}}
            User Reports
        </a>
    </nav>
</aside>

<div class="w-full flex flex-col h-screen overflow-y-hidden">
