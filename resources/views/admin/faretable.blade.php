@extends('admin.theme.default')

@section('content')

<h1 class="w-full text-3xl text-black pb-6">Add Fare Rates</h1>

<div class="flex flex-wrap">
    <!-- Fare Rates Form Section -->
    <div class="w-full lg:w-1/2 my-6 pr-0 lg:pr-2">
        <p class="text-xl pb-6 flex items-center">
            <i class="fas fa-list mr-3"></i> Fare Rates Form
        </p>
        <div class="leading-loose">
            <form action="{{ route('admin.fare.store') }}" method="POST" class="p-10 bg-white rounded shadow-xl">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm text-gray-600" for="base_fare">Base Fare (₱)</label>
                    <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="base_fare" name="base_fare" type="number" step="0.01" required placeholder="e.g. 30.00">
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-gray-600" for="per_km_rate">Rate per Km (₱)</label>
                    <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="per_km_rate" name="per_km_rate" type="number" step="0.01" required placeholder="e.g. 10.00">
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-gray-600" for="base_distance_km">Base Distance (km)</label>
                    <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="base_distance_km" name="base_distance_km" type="number" step="0.01" required placeholder="e.g. 1.00">
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-gray-600" for="currency">Currency</label>
                    <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="currency" name="currency" type="text" maxlength="3" readonly value="PHP" required>
                </div>

                <div class="mt-6">
                    <button class="px-4 py-1 text-white font-light tracking-wider bg-gray-900 rounded" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Current Fare Rates Section -->
    <div class="w-full lg:w-1/2 my-6 pr-0 lg:pl-2">
        <p class="text-xl pb-6 flex items-center">
            <i class="fas fa-table mr-3"></i> Current Fare Rates
        </p>

        <!-- Display the total number of fares -->
        <div class="flex items-center justify-between mb-6">
            <p class="text-lg text-gray-600">Fares Created: <span class="font-semibold text-gray-800">{{ $fares->count() }}</span></p>
        </div>

        <div class="bg-white rounded shadow overflow-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-3 px-4 text-left text-sm font-semibold">#</th>
                        <th hidden class="py-3 px-4 text-left text-sm font-semibold">ID</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold">Base Fare (₱)</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold">Per Km (₱)</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold">Base Distance (km)</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold">Created</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @if ($fares->isNotEmpty())
                    @foreach($fares as $index => $fare)
                    <tr class="{{ $loop->even ? 'bg-gray-100' : '' }}">
                        <td class="py-2 px-4">{{ $index + 1 }}</td>
                        <td hidden class="py-2 px-4">{{ $fare->id }}</td>
                        <td class="py-2 px-4">{{ number_format($fare->base_fare, 2) }}</td>
                        <td class="py-2 px-4">{{ number_format($fare->per_km_rate, 2) }}</td>
                        <td class="py-2 px-4">{{ number_format($fare->base_distance_km, 2) }}</td>
                        <td class="py-2 px-4">{{ $fare->created_at->format('Y-m-d H:i') }}</td>
                        <td class="py-2 px-4">
                            <a href="" class="text-red-500 hover:text-red-700 ml-2"
                                onclick="event.preventDefault(); document.getElementById('delete-form-{{ $fare->id }}').submit();">Delete</a>

                            <form id="delete-form-{{ $fare->id }}" action="{{ route('admin.delete_fare.destroy', $fare->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="user_id" value="{{ $fare->id }}">
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="7" class="text-center py-2 px-4">No fare rates found.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection