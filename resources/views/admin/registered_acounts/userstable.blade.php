@extends('admin.theme.default')

@section('content')

<div class="w-full mt-12">
    <!-- Header Section -->
    <p class="text-2xl font-semibold text-gray-800 pb-6 flex items-center">
        <i class="fas fa-users mr-3"></i> Registered Users Accounts
    </p>

    <!-- Display the total number of users -->
    <div class="flex items-center justify-between mb-6">
        <p class="text-lg text-gray-600">Total Users: <span class="font-semibold text-gray-800">{{ $users->count() }}</span></p>
        <a href="{{ route('admin.register') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition duration-300">Add User</a>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="min-w-full bg-white table-auto">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-4 text-left text-sm font-semibold">#</th>
                    <th hidden class="py-3 px-4 text-left text-sm font-semibold">ID</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold">Name</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold">Email Address</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold">Usertype</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold">Created At</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">

                @if($users && $users->count())
                @foreach($users as $index => $user)
                <tr class="{{ $loop->even ? 'bg-gray-100' : '' }}">
                    <td class="py-2 px-4">{{ $index + 1 }}</td>
                    <td hidden class="py-2 px-4">{{ $user->id }}</td>
                    <td class="py-2 px-4">{{ $user->name }}</td>
                    <td class="py-2 px-4">{{ $user->email }}</td>
                    <td class="py-2 px-4">{{ $user->usertype }}</td>
                    <td class="py-2 px-4">{{ $user->created_at->format('Y-m-d H:i') }}</td>
                    <td class="py-2 px-4">
                        <!-- Action Buttons -->
                        <a href="{{ route('admin.update_account', $user->id) }}" class="text-blue-500 hover:text-blue-700">Edit</a>
                        <a href="" class="text-red-500 hover:text-red-700 ml-2"
                            onclick="event.preventDefault(); document.getElementById('delete-form-{{ $user->id }}').submit();">Delete</a>
                        
                        <form id="delete-form-{{ $user->id }}" action="{{ route('admin.delete_user.destroy', $user->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                        </form>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="7" class="text-center py-2 px-4">No users found.</td>
                </tr>
                @endif
            </tbody>
        </table>
        <div class="flex justify-between py-4">
            {{ $users->links() }} <!-- Pagination links -->
        </div>

    </div>
</div>

@endsection