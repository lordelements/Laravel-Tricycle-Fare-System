<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">Request a Trip</h2>

                    @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 mb-4 rounded">
                        {{ session('success') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('trip.store') }}">
                        @csrf

                        <input type="hidden" name="pickup_lat" id="pickup_lat">
                        <input type="hidden" name="pickup_lng" id="pickup_lng">
                        <input type="hidden" name="dest_lat" id="dest_lat">
                        <input type="hidden" name="dest_lng" id="dest_lng">
                        <input type="hidden" name="distance" id="distance">
                        <input type="hidden" name="estimated_price" id="estimated_price">

                        <!-- Current Location -->
                        <div class="mb-4">
                            <label for="pickup" class="block text-gray-700 dark:text-gray-200 font-medium">Current Location (Barangay)</label>
                            <input type="text" name="pickup" id="pickup" readonly
                                class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-white">
                        </div>

                        <!-- Destination -->
                        <div class="mb-4">
                            <label for="destination" class="block text-gray-700 dark:text-gray-200 font-medium">Destination</label>
                            <input type="text" name="destination" id="destination" readonly
                                class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-white">
                        </div>

                        <!-- Live Map -->
                        <div id="map" class="h-[400px] rounded mb-6"></div>

                        <!-- Fare Info -->
                        <div class="text-sm text-gray-700 dark:text-gray-300 mb-4">
                            Distance: <span id="distanceText">0</span> km | Estimated Fare: <span id="fareText">0</span> PHP
                        </div>
                        <!-- Latest Fare Price Rate -->
                        @if(isset($latestFare))
                        <div class="text-sm text-gray-700 dark:text-gray-300 mb-4">
                            <p class="font-semibold text-gray-800 dark:text-white mb-2">Latest Fare Settings</p>
                            <div class="bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg p-4">
                                <ul class="list-disc ml-5 space-y-1 text-gray-700 dark:text-gray-200">
                                    <li><span class="font-medium">Base Fare:</span> ₱{{ number_format($latestFare->base_fare, 2) }}</li>
                                    <li><span class="font-medium">Per KM Rate:</span> ₱{{ number_format($latestFare->per_km_rate, 2) }}</li>
                                    <li><span class="font-medium">Base Distance:</span> {{ $latestFare->base_distance_km }} km</li>
                                    <li><span class="font-medium">Currency:</span> {{ $latestFare->currency }}</li>
                                </ul>
                            </div>
                        </div>
                        @else
                        <div class="text-sm text-gray-700 dark:text-gray-300 mb-4">
                            <div class="bg-yellow-100 dark:bg-yellow-700 border border-yellow-400 dark:border-yellow-600 rounded p-4 text-yellow-800 dark:text-yellow-100">
                                <p>No fare rates available yet.</p>
                            </div>
                        </div>
                        @endif

                        <!-- Submit -->
                        <div class="mt-6">
                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded">
                                Request Trip
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet CDN -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        const map = L.map('map').setView([12.7842, 123.8634], 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        let pickupMarker, destMarker;

        // Get current location and set as pickup
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(async function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    const latlng = [lat, lng];

                    map.setView(latlng, 15);

                    pickupMarker = L.marker(latlng, {
                        draggable: false
                    }).addTo(map).bindPopup('Pickup').openPopup();

                    document.getElementById('pickup_lat').value = lat;
                    document.getElementById('pickup_lng').value = lng;

                    try {
                        const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`);
                        const data = await response.json();

                        const barangay =
                            data.address.village || data.address.suburb || data.address.neighborhood ||
                            data.address.hamlet || data.address.town || data.address.city_district ||
                            data.address.city || data.address.municipality || data.address.county ||
                            data.address.state || data.display_name || 'Unknown Location';

                        document.getElementById('pickup').value = barangay;
                    } catch (error) {
                        console.error('Reverse geocoding failed:', error);
                        document.getElementById('pickup').value = `${lat}, ${lng}`;
                    }
                },
                function() {
                    alert('Unable to retrieve your location.');
                });
        } else {
            alert('Geolocation is not supported by your browser.');
        }

        // Set destination on map click
        map.on('click', function(e) {
            if (!destMarker) {
                destMarker = L.marker(e.latlng, {
                    draggable: true
                }).addTo(map).bindPopup('Destination').openPopup();
                destMarker.on('dragend', updateInfo);
            } else {
                destMarker.setLatLng(e.latlng);
            }
            updateInfo();
        });

        async function updateInfo() {
            if (pickupMarker && destMarker) {
                const lat1 = pickupMarker.getLatLng().lat;
                const lon1 = pickupMarker.getLatLng().lng;
                const lat2 = destMarker.getLatLng().lat;
                const lon2 = destMarker.getLatLng().lng;

                document.getElementById('dest_lat').value = lat2;
                document.getElementById('dest_lng').value = lon2;

                try {
                    const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat2}&lon=${lon2}`);
                    const data = await response.json();
                    const place = data.address.road || data.address.village || data.display_name || `${lat2}, ${lon2}`;
                    document.getElementById('destination').value = place;
                } catch (error) {
                    console.error('Reverse geocoding for destination failed:', error);
                    document.getElementById('destination').value = `${lat2}, ${lon2}`;
                }

                const dist = getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2);
                document.getElementById('distance').value = dist.toFixed(2);
                document.getElementById('distanceText').innerText = dist.toFixed(2);

                let fare = 30;
                if (dist > 1) fare += (dist - 1) * 10;

                document.getElementById('estimated_price').value = fare.toFixed(2);
                document.getElementById('fareText').innerText = fare.toFixed(2);
            }
        }

        function getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2) {
            const R = 6371; // Earth radius in km
            const dLat = deg2rad(lat2 - lat1);
            const dLon = deg2rad(lon2 - lon1);
            const a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c;
        }

        function deg2rad(deg) {
            return deg * (Math.PI / 180);
        }
    </script>

    <style>
        #map {
            height: 400px;
        }

        button {
            background-color: #4F46E5;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
        }
    </style>
</x-app-layout>