<div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-semibold text-gray-900 mb-6">Find Nearby {{ $userType === 'store' ? 'Stores' : 'Mechanics' }}</h1>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                <div class="px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <!-- User Location -->
                        <div class="sm:col-span-6">
                            <h3 class="text-lg font-medium text-gray-900">Your Location</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Use current location or enter your address manually.
                            </p>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
                            <div class="mt-1">
                                <input
                                    type="text"
                                    wire:model.defer="latitude"
                                    id="latitude"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                >
                                @error('latitude') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
                            <div class="mt-1">
                                <input
                                    type="text"
                                    wire:model.defer="longitude"
                                    id="longitude"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                >
                                @error('longitude') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="sm:col-span-4">
                            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                            <div class="mt-1">
                                <input
                                    type="text"
                                    wire:model.defer="address"
                                    id="address"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                >
                                @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <div class="mt-7">
                                <button
                                    wire:click="detectLocation"
                                    type="button"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >
                                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Detect My Location
                                </button>
                            </div>
                        </div>

                        <!-- Search Options -->
                        <div class="sm:col-span-2">
                            <label for="userType" class="block text-sm font-medium text-gray-700">I'm looking for a</label>
                            <div class="mt-1">
                                <select
                                    wire:model.defer="userType"
                                    id="userType"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                >
                                    <option value="store">Store</option>
                                    <option value="mechanic">Mechanic</option>
                                </select>
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="searchRadius" class="block text-sm font-medium text-gray-700">Radius (km)</label>
                            <div class="mt-1">
                                <input
                                    type="number"
                                    wire:model.defer="searchRadius"
                                    id="searchRadius"
                                    min="1"
                                    max="100"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                >
                                @error('searchRadius') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <div class="flex justify-end mt-7">
                                <button
                                    wire:click="search"
                                    wire:loading.attr="disabled"
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >
                                    <svg wire:loading wire:target="search" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Search
                                </button>
                            </div>
                        </div>

                        <!-- Save Location Button -->
                        <div class="sm:col-span-6">
                            <div class="flex justify-center mt-2">
                                <button
                                    wire:click="saveUserLocation"
                                    wire:loading.attr="disabled"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >
                                    <svg wire:loading wire:target="saveUserLocation" class="animate-spin -ml-1 mr-2 h-4 w-4 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Save My Location
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Map Section -->
            @if($showMap && $latitude && $longitude)
                <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Map</h3>
                        <div id="map" style="height: 400px;" wire:ignore></div>
                    </div>
                </div>
            @endif

            <!-- Search Results -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        Search Results ({{ count($searchResults) }})
                    </h3>

                    @if($errorMessage)
                        <div class="rounded-md bg-red-50 p-4 mb-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">Error</h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <p>{{ $errorMessage }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(count($searchResults) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Distance</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($searchResults as $result)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $result->name }}</div>
                                            <div class="text-sm text-gray-500">{{ ucfirst($result->role) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $result->address ?: 'Address not provided' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ number_format($result->distance, 2) }} km
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('profile.show', $result) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View Profile</a>
                                            @if(Auth::user()->role === 'mechanic' && $result->role === 'store')
                                                <a href="{{ route('quotes.create', ['store_id' => $result->id]) }}" class="text-green-600 hover:text-green-900">Create Quote</a>
                                            @endif
                                            @if(Auth::user()->role === 'client' && $result->role === 'mechanic')
                                                <a href="{{ route('appointments.create', ['mechanic_id' => $result->id]) }}" class="text-green-600 hover:text-green-900">Book Appointment</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @elseif(!$errorMessage && $isSearching === false)
                        <p class="text-gray-500 text-center py-4">No results found. Try adjusting your search parameters.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Map and Geolocation -->
    @push('scripts')
        <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&libraries=places"></script>
        <script>
            document.addEventListener('livewire:load', function() {
                // Initialize map when latitude and longitude are available
                @if($latitude && $longitude)
                initMap();
                @endif

                // Get geolocation when requested
                Livewire.on('getLocation', function() {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            // Success
                            function(position) {
                                const lat = position.coords.latitude;
                                const lng = position.coords.longitude;

                                // Get address from coordinates using Google's Geocoding API
                                const geocoder = new google.maps.Geocoder();
                                const latlng = { lat: lat, lng: lng };

                                geocoder.geocode({ location: latlng }, function(results, status) {
                                    if (status === "OK" && results[0]) {
                                        Livewire.emit('updateLocation', lat, lng, results[0].formatted_address);
                                    } else {
                                        Livewire.emit('updateLocation', lat, lng);
                                    }
                                });
                            },
                            // Error
                            function(error) {
                                console.error("Error getting location: ", error);
                                alert("Couldn't get your location. Error: " + error.message);
                            }
                        );
                    } else {
                        alert("Geolocation is not supported by this browser.");
                    }
                });

                // Listen for map updates
                Livewire.on('mapUpdated', function() {
                    initMap();
                });

                // Function to initialize map
                function initMap() {
                    const mapElement = document.getElementById('map');
                    if (!mapElement) return;

                    const userLat = parseFloat(@this.latitude);
                    const userLng = parseFloat(@this.longitude);

                    if (isNaN(userLat) || isNaN(userLng)) return;

                    const userLocation = { lat: userLat, lng: userLng };

                    const map = new google.maps.Map(mapElement, {
                        center: userLocation,
                        zoom: 12,
                    });

                    // Add marker for user location
                    new google.maps.Marker({
                        position: userLocation,
                        map: map,
                        title: "Your Location",
                        icon: {
                            url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png"
                        }
                    });

                    // Add markers for search results
                    @if(count($searchResults) > 0)
                    const bounds = new google.maps.LatLngBounds();
                    bounds.extend(userLocation);

                    @foreach($searchResults as $result)
                    @if($result->latitude && $result->longitude)
                    const resultLat = parseFloat({{ $result->latitude }});
                    const resultLng = parseFloat({{ $result->longitude }});

                    if (!isNaN(resultLat) && !isNaN(resultLng)) {
                        const position = { lat: resultLat, lng: resultLng };

                        // Create marker
                        const marker = new google.maps.Marker({
                            position: position,
                            map: map,
                            title: "{{ $result->name }}",
                            icon: {
                                url: "http://maps.google.com/mapfiles/ms/icons/{{ $result->role === 'store' ? 'green' : 'red' }}-dot.png"
                            }
                        });

                        // Create info window
                        const infoWindow = new google.maps.InfoWindow({
                            content: `
                                        <div>
                                            <h3 class="font-medium">{{ $result->name }}</h3>
                                            <p>{{ ucfirst($result->role) }}</p>
                                            <p>{{ $result->address ?: 'Address not provided' }}</p>
                                            <p>Distance: {{ number_format($result->distance, 2) }} km</p>
                                        </div>
                                    `
                        });

                        // Add click listener to show info window
                        marker.addListener('click', function() {
                            infoWindow.open(map, marker);
                        });

                        bounds.extend(position);
                    }
                    @endif
                    @endforeach

                    // Fit map to show all markers
                    map.fitBounds(bounds);
                    @endif
                }
            });
        </script>
    @endpush
</div>
