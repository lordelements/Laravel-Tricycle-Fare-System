
        const fareElement = document.getElementById('fare-data');
        const mapLoadingOverlay = document.getElementById('map-loading-overlay');

        const fareSettings = {
            base_fare: parseFloat(fareElement.dataset.baseFare),
            per_km_rate: parseFloat(fareElement.dataset.perKmRate),
            base_distance_km: parseFloat(fareElement.dataset.baseDistanceKm),
        };

        console.log(fareSettings);

        // Function to show the map loading overlay
        function showMapLoading() {
            mapLoadingOverlay.classList.remove('hidden');
        }

        // Function to hide the map loading overlay
        function hideMapLoading() {
            mapLoadingOverlay.classList.add('hidden');
        }

        // Initialize the map (showing loading before initialization)
        showMapLoading();
        const map = L.map('map').setView([12.7842, 123.8634], 14); // Set initial view to a general area in the Philippines
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Once the map tiles are loaded, hide the initial loading overlay
        map.on('baselayerchange', hideMapLoading); // For layers that change
        map.on('load', hideMapLoading); // For initial load (might not fire reliably on all browsers/contexts)
        // A timeout is a good fallback if `load` event isn't reliable for initial tiles
        setTimeout(hideMapLoading, 1500); // Hide after 1.5 seconds if no load event

        let pickupMarker, destMarker, routeLine;
        let mode = 'auto'; // Default mode is 'auto' (automatic location detection)

        // Initial location detection when the page loads
        detectCurrentLocation();

        // Event listeners for location mode radio buttons
        document.getElementById('modeAuto').addEventListener('change', () => {
            mode = 'auto';
            detectCurrentLocation(); // Redetect location for auto mode
        });

        document.getElementById('modeManual').addEventListener('change', () => {
            mode = 'manual';
            // Clear existing pickup marker and related fields when switching to manual mode
            if (pickupMarker) {
                map.removeLayer(pickupMarker);
                pickupMarker = null;
            }
            document.getElementById('pickup').value = '';
            document.getElementById('pickup_lat').value = '';
            document.getElementById('pickup_lng').value = '';

            // Clear route line if it exists
            if (routeLine) {
                map.removeLayer(routeLine);
                routeLine = null;
                // Reset distance and fare display
                document.getElementById('distance').value = '0';
                document.getElementById('distanceText').innerText = '0';
                document.getElementById('estimated_price').value = '0';
                document.getElementById('fareText').innerText = '0';
            }
        });

        // Function to detect current user location
        function detectCurrentLocation() {
            showMapLoading(); // Show loading when detecting location
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(async function(position) {
                    hideMapLoading(); // Hide loading on success
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    const latlng = L.latLng(lat, lng);

                    map.setView(latlng, 15); // Center map on current location

                    // Remove existing pickup marker if any
                    if (pickupMarker) map.removeLayer(pickupMarker);

                    // Create new pickup marker at current location
                    pickupMarker = L.marker(latlng, {
                        draggable: mode === 'manual', // Only draggable in manual mode
                        icon: L.divIcon({
                            className: 'custom-pickup-icon',
                            html: '<div class="pickup-marker"></div>',
                            iconSize: [30, 30]
                        })
                    }).addTo(map).bindPopup('Pickup Location').openPopup();

                    // Attach dragend listener if in manual mode
                    if (mode === 'manual') {
                        pickupMarker.on('dragend', updatePickupLocation);
                    }

                    // Set hidden input fields
                    document.getElementById('pickup_lat').value = lat;
                    document.getElementById('pickup_lng').value = lng;

                    // Reverse geocode to get human-readable address for pickup
                    await reverseGeocode(lat, lng, 'pickup');

                    // If a destination is already set, update the route and fare
                    if (destMarker) {
                        updateDistanceAndFare();
                    }

                },
                function(error) {
                    hideMapLoading(); // Hide loading on error
                    // Suppress console error if it's due to permissions policy
                    if (!(error.message && error.message.includes('Geolocation has been disabled in this document by permissions policy'))) {
                        console.error('Geolocation error:', error);
                        console.error('Unable to retrieve your location. Please allow location access or use manual mode. Error:', error.message || error);
                    }

                    // Always switch to manual mode and disable auto option on any geolocation error
                    document.getElementById('modeManual').checked = true; // Select manual mode
                    document.getElementById('modeAuto').disabled = true; // Disable the automatic option
                    mode = 'manual'; // Ensure mode is set to manual fallback
                    // Clear pickup marker and location fields if auto-detection fails
                    if (pickupMarker) map.removeLayer(pickupMarker);
                    pickupMarker = null;
                    document.getElementById('pickup').value = '';
                    document.getElementById('pickup_lat').value = '';
                    document.getElementById('pickup_lng').value = '';
                });
            } else {
                hideMapLoading(); // Hide loading if geolocation not supported
                // Inform user if geolocation is not supported by their browser at all
                console.error('Geolocation is not supported by your browser. Using manual mode.');
                document.getElementById('modeManual').checked = true;
                document.getElementById('modeAuto').disabled = true; // Disable auto option if not supported
                mode = 'manual'; // Force switch to manual mode
            }
        }

        // Handle map clicks for setting pickup (in manual mode) and destination (in any mode)
        map.on('click', function(e) {
            const latlng = e.latlng; // Clicked latitude and longitude

            // If in manual mode and no pickup marker is set, create one
            if (mode === 'manual' && !pickupMarker) {
                showMapLoading(); // Show loading before creating marker and geocoding
                pickupMarker = L.marker(latlng, {
                    draggable: true,
                    icon: L.divIcon({
                        className: 'custom-pickup-icon',
                        html: '<div class="pickup-marker"></div>',
                        iconSize: [30, 30]
                    })
                }).addTo(map).bindPopup('Pickup Location').openPopup();

                pickupMarker.on('dragend', updatePickupLocation); // Attach drag listener

                document.getElementById('pickup_lat').value = latlng.lat;
                document.getElementById('pickup_lng').value = latlng.lng;

                reverseGeocode(latlng.lat, latlng.lng, 'pickup').then(hideMapLoading).catch(hideMapLoading); // Hide loading after geocoding
            }
            // If a destination marker is not set OR if a destination marker is set but we are clicking to update it
            else if (!destMarker || (destMarker && mode === 'manual' && pickupMarker)) { // Allow updating destination in manual mode if pickup exists
                showMapLoading(); // Show loading before creating marker and geocoding
                if (destMarker) { // If destination marker already exists, remove it first
                    map.removeLayer(destMarker);
                }
                destMarker = L.marker(latlng, {
                    draggable: true,
                    icon: L.divIcon({
                        className: 'custom-destination-icon',
                        html: '<div class="destination-marker"></div>',
                        iconSize: [30, 30]
                    })
                }).addTo(map).bindPopup('Destination').openPopup();

                destMarker.on('dragend', updateDestination); // Attach drag listener

                document.getElementById('dest_lat').value = latlng.lat;
                document.getElementById('dest_lng').value = latlng.lng;

                reverseGeocode(latlng.lat, latlng.lng, 'destination').then(hideMapLoading).catch(hideMapLoading); // Hide loading after geocoding
            }
            // For destination in any mode, if clicked after pickup is set (and not in manual mode where pickup might be null)
            else if (pickupMarker && !destMarker) {
                showMapLoading(); // Show loading before creating marker and geocoding
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

                reverseGeocode(latlng.lat, latlng.lng, 'destination').then(hideMapLoading).catch(hideMapLoading);
            } else if (destMarker) { // If both markers exist, this click is probably to move the destination
                showMapLoading();
                destMarker.setLatLng(latlng);
                updateDestination().then(hideMapLoading).catch(hideMapLoading); // Update destination and hide loading
            }


            // If both pickup and destination markers are set, update the route and fare
            if (pickupMarker && destMarker) {
                updateDistanceAndFare();
            }
        });

        // Function to update pickup location when marker is dragged
        async function updatePickupLocation() {
            showMapLoading();
            const latlng = pickupMarker.getLatLng();
            document.getElementById('pickup_lat').value = latlng.lat;
            document.getElementById('pickup_lng').value = latlng.lng;
            await reverseGeocode(latlng.lat, latlng.lng, 'pickup');

            if (destMarker) {
                await updateDistanceAndFare();
            }
            hideMapLoading();
        }

        // Function to update destination when marker is dragged
        async function updateDestination() {
            showMapLoading();
            const latlng = destMarker.getLatLng();
            document.getElementById('dest_lat').value = latlng.lat;
            document.getElementById('dest_lng').value = latlng.lng;
            await reverseGeocode(latlng.lat, latlng.lng, 'destination');

            if (pickupMarker) {
                await updateDistanceAndFare();
            }
            hideMapLoading();
        }

        // Function to add a route line between pickup and destination using OSRM
        async function addRoute(startLatLng, endLatLng) {
            showMapLoading(); // Show loading when fetching route
            if (routeLine) {
                map.removeLayer(routeLine); // Remove existing route line
            }

            // OSRM routing service URL
            const serviceUrl = 'https://router.project-osrm.org';
            const url = `${serviceUrl}/route/v1/driving/` +
                `${startLatLng.lng},${startLatLng.lat};${endLatLng.lng},${endLatLng.lat}` +
                `?overview=full&geometries=geojson&alternatives=false`;

            try {
                const response = await fetch(url);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const data = await response.json();

                if (data.code === 'Ok') {
                    const route = data.routes[0];
                    const routeCoordinates = L.GeoJSON.coordsToLatLngs(
                        route.geometry.coordinates // Convert GeoJSON coordinates to Leaflet LatLngs
                    );

                    // Create route line with custom style (blue dashed line)
                    routeLine = L.polyline(routeCoordinates, {
                        color: '#3b82f6', // Tailwind blue-600
                        weight: 5,
                        opacity: 0.8,
                        dashArray: '10, 10', // Dashed line
                        lineJoin: 'round'
                    }).addTo(map);

                    // Fit map bounds to show the entire route with some padding
                    map.fitBounds(routeLine.getBounds(), {
                        padding: [50, 50]
                    });

                    // Update distance with actual route distance from OSRM (meters to km)
                    const routeDistance = (route.distance / 1000).toFixed(2);
                    document.getElementById('distance').value = routeDistance;
                    document.getElementById('distanceText').innerText = routeDistance;

                    updateFare(routeDistance); // Update fare based on calculated distance
                } else {
                    // Handle OSRM error, e.g., if no route found
                    console.error('OSRM route error:', data.code, data.message);
                    fallbackRouteCalculation(startLatLng, endLatLng);
                }
            } catch (error) {
                console.error('Error fetching route:', error);
                // Fallback to straight-line distance if OSRM fails
                fallbackRouteCalculation(startLatLng, endLatLng);
            } finally {
                hideMapLoading(); // Hide loading after route calculation (success or error)
            }
        }

        // Fallback function for route calculation (straight-line distance)
        function fallbackRouteCalculation(startLatLng, endLatLng) {
            // Add a simple straight line if routing service fails
            routeLine = L.polyline([startLatLng, endLatLng], {
                color: '#3b82f6', // Tailwind blue-600
                weight: 3,
                opacity: 0.7,
                dashArray: '5, 5'
            }).addTo(map);
            map.fitBounds([startLatLng, endLatLng]); // Fit map to start and end points

            // Calculate straight-line distance (Haversine formula)
            const distance = getDistanceFromLatLonInKm(
                startLatLng.lat, startLatLng.lng,
                endLatLng.lat, endLatLng.lng
            ).toFixed(2);

            document.getElementById('distance').value = distance;
            document.getElementById('distanceText').innerText = distance;
            updateFare(distance);
            hideMapLoading(); // Hide loading if this fallback is used
        }


        // Update distance and fare when markers move
        async function updateDistanceAndFare() {
            if (pickupMarker && destMarker) {
                const pickupLatLng = pickupMarker.getLatLng();
                const destLatLng = destMarker.getLatLng();
                await addRoute(pickupLatLng, destLatLng);
            }
        }

        // Calculate fare based on distance using provided fare settings
        function updateFare(distance) {
            let fare = fareSettings.base_fare;
            if (parseFloat(distance) > fareSettings.base_distance_km) {
                fare += (parseFloat(distance) - fareSettings.base_distance_km) * fareSettings.per_km_rate;
            }

            document.getElementById('estimated_price').value = fare.toFixed(2);
            document.getElementById('fareText').innerText = fare.toFixed(2);
        }

        // Generic reverse geocoding function using Nominatim
        async function reverseGeocode(lat, lng, fieldPrefix) {
            try {
                const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`);
                const data = await response.json();

                // Prioritize specific address components, then display_name, then just lat/lng
                const displayName = data.address?.road || data.address?.village ||
                    data.address?.city || data.display_name || `${lat.toFixed(4)}, ${lng.toFixed(4)}`;

                document.getElementById(fieldPrefix === 'pickup' ? 'pickup' : 'destination').value = displayName;
            } catch (error) {
                console.error('Reverse geocoding failed:', error);
                document.getElementById(fieldPrefix === 'pickup' ? 'pickup' : 'destination').value = `${lat.toFixed(4)}, ${lng.toFixed(4)}`;
            }
        }

        // Helper function to calculate straight-line distance between two points (Haversine formula)
        function getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2) {
            const R = 6371; // Radius of Earth in kilometers
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