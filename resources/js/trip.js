
const fareElement = document.getElementById('fare-data');
const fareSettings = {
    base_fare: parseFloat(fareElement.dataset.baseFare),
    per_km_rate: parseFloat(fareElement.dataset.perKmRate),
    base_distance_km: parseFloat(fareElement.dataset.baseDistanceKm),
};

console.log(fareSettings);

const map = L.map('map').setView([12.7842, 123.8634], 14);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

let pickupMarker, destMarker, routeLine;
let mode = 'auto';

// Initialize with automatic location detection
detectCurrentLocation();

// Event listeners for location mode
document.getElementById('modeAuto').addEventListener('change', () => {
    mode = 'auto';
    detectCurrentLocation();
});

document.getElementById('modeManual').addEventListener('change', () => {
    mode = 'manual';
    if (pickupMarker) {
        map.removeLayer(pickupMarker);
        pickupMarker = null;
    }
    document.getElementById('pickup').value = '';
    document.getElementById('pickup_lat').value = '';
    document.getElementById('pickup_lng').value = '';

    // Clear route if exists
    if (routeLine) {
        map.removeLayer(routeLine);
        routeLine = null;
    }
});

// Main function to detect current location
function detectCurrentLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(async function (position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            const latlng = L.latLng(lat, lng);

            map.setView(latlng, 15);

            // Remove existing pickup marker
            if (pickupMarker) map.removeLayer(pickupMarker);

            // Create new pickup marker
            pickupMarker = L.marker(latlng, {
                draggable: mode === 'manual',
                icon: L.divIcon({
                    className: 'custom-pickup-icon',
                    html: '<div class="pickup-marker"></div>',
                    iconSize: [30, 30]
                })
            }).addTo(map).bindPopup('Pickup Location').openPopup();

            if (mode === 'manual') {
                pickupMarker.on('dragend', updatePickupLocation);
            }

            // Set hidden fields
            document.getElementById('pickup_lat').value = lat;
            document.getElementById('pickup_lng').value = lng;

            // Get address using reverse geocoding
            await reverseGeocode(lat, lng, 'pickup');

            // If destination exists, update route
            if (destMarker) {
                updateDistanceAndFare();
            }

        }, function (error) {
            console.error('Geolocation error:', error);
            alert('Unable to retrieve your location. Please allow location access or use manual mode.');
        });
    } else {
        alert('Geolocation is not supported by your browser. Using manual mode.');
        document.getElementById('modeManual').checked = true;
        mode = 'manual';
    }
}

// Handle map clicks
map.on('click', function (e) {
    const latlng = e.latlng;

    // For pickup location in manual mode
    if (mode === 'manual' && !pickupMarker) {
        pickupMarker = L.marker(latlng, {
            draggable: true,
            icon: L.divIcon({
                className: 'custom-pickup-icon',
                html: '<div class="pickup-marker"></div>',
                iconSize: [30, 30]
            })
        }).addTo(map).bindPopup('Pickup Location').openPopup();

        pickupMarker.on('dragend', updatePickupLocation);

        document.getElementById('pickup_lat').value = latlng.lat;
        document.getElementById('pickup_lng').value = latlng.lng;

        reverseGeocode(latlng.lat, latlng.lng, 'pickup');
    }
    // For destination in any mode
    else if (!destMarker) {
        destMarker = L.marker(latlng, {
            draggable: true,
            icon: L.divIcon({
                className: 'custom-destination-icon',
                html: '<div class="destination-marker"></div>',
                iconSize: [30, 30]
            })
        }).addTo(map).bindPopup('Destination').openPopup();

        destMarker.on('dragend', updateDestination);

        document.getElementById('dest_lat').value = latlng.lat;
        document.getElementById('dest_lng').value = latlng.lng;

        reverseGeocode(latlng.lat, latlng.lng, 'destination');
    } else {
        destMarker.setLatLng(latlng);
        updateDestination();
    }

    // Update route if both points exist
    if (pickupMarker && destMarker) {
        updateDistanceAndFare();
    }
});

// Function to update pickup location when marker is dragged
function updatePickupLocation() {
    const latlng = pickupMarker.getLatLng();
    document.getElementById('pickup_lat').value = latlng.lat;
    document.getElementById('pickup_lng').value = latlng.lng;
    reverseGeocode(latlng.lat, latlng.lng, 'pickup');

    if (destMarker) {
        updateDistanceAndFare();
    }
}

// Function to update destination when marker is dragged
function updateDestination() {
    const latlng = destMarker.getLatLng();
    document.getElementById('dest_lat').value = latlng.lat;
    document.getElementById('dest_lng').value = latlng.lng;
    reverseGeocode(latlng.lat, latlng.lng, 'destination');

    if (pickupMarker) {
        updateDistanceAndFare();
    }
}

// Add route to map
function addRoute(startLatLng, endLatLng) {
    // Remove existing route if any
    if (routeLine) {
        map.removeLayer(routeLine);
    }

    // Use OSRM routing service
    const serviceUrl = 'https://router.project-osrm.org';
    const url = `${serviceUrl}/route/v1/driving/` +
        `${startLatLng.lng},${startLatLng.lat};${endLatLng.lng},${endLatLng.lat}` +
        `?overview=full&geometries=geojson&alternatives=false`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.code === 'Ok') {
                const route = data.routes[0];
                const routeCoordinates = L.GeoJSON.coordsToLatLngs(
                    route.geometry.coordinates
                );

                // Create route line with custom style
                routeLine = L.polyline(routeCoordinates, {
                    color: '#3b82f6',
                    weight: 5,
                    opacity: 0.8,
                    dashArray: '10, 10',
                    lineJoin: 'round'
                }).addTo(map);

                // Fit map to show entire route with padding
                map.fitBounds(routeLine.getBounds(), { padding: [50, 50] });

                // Update distance with actual route distance
                const routeDistance = (route.distance / 1000).toFixed(2);
                document.getElementById('distance').value = routeDistance;
                document.getElementById('distanceText').innerText = routeDistance;

                // Update fare calculation
                updateFare(routeDistance);
            }
        })
        .catch(error => {
            console.error('Error fetching route:', error);
            // Fallback to straight line if routing fails
            routeLine = L.polyline([startLatLng, endLatLng], {
                color: '#3b82f6',
                weight: 3,
                opacity: 0.7,
                dashArray: '5, 5'
            }).addTo(map);
            map.fitBounds([startLatLng, endLatLng]);

            // Calculate straight-line distance
            const distance = getDistanceFromLatLonInKm(
                startLatLng.lat, startLatLng.lng,
                endLatLng.lat, endLatLng.lng
            ).toFixed(2);

            document.getElementById('distance').value = distance;
            document.getElementById('distanceText').innerText = distance;
            updateFare(distance);
        });
}

// Update distance and fare
function updateDistanceAndFare() {
    if (pickupMarker && destMarker) {
        const pickupLatLng = pickupMarker.getLatLng();
        const destLatLng = destMarker.getLatLng();
        addRoute(pickupLatLng, destLatLng);
    }
}

// Calculate fare based on distance
function updateFare(distance) {
    let fare = fareSettings.base_fare;
    if (distance > fareSettings.base_distance_km) {
        fare += (distance - fareSettings.base_distance_km) * fareSettings.per_km_rate;
    }

    document.getElementById('estimated_price').value = fare.toFixed(2);
    document.getElementById('fareText').innerText = fare.toFixed(2);
}

// Generic reverse geocoding function
async function reverseGeocode(lat, lng, fieldPrefix) {
    try {
        const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`);
        const data = await response.json();

        const displayName = data.address?.road || data.address?.village ||
            data.address?.city || data.display_name || `${lat}, ${lng}`;

        document.getElementById(fieldPrefix === 'pickup' ? 'pickup' : 'destination').value = displayName;
    } catch (error) {
        console.error('Reverse geocoding failed:', error);
        document.getElementById(fieldPrefix === 'pickup' ? 'pickup' : 'destination').value = `${lat}, ${lng}`;
    }
}

// Helper function to calculate distance between two points
function getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2) {
    const R = 6371; // Radius of the earth in km
    const dLat = deg2rad(lat2 - lat1);
    const dLon = deg2rad(lon2 - lon1);
    const a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
        Math.sin(dLon / 2) * Math.sin(dLon / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return R * c; // Distance in km
}

function deg2rad(deg) {
    return deg * (Math.PI / 180);
}
