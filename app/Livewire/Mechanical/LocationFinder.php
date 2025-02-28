<?php

namespace App\Livewire\Mechanical;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LocationFinder extends Component
{
    public $latitude;
    public $longitude;
    public $searchRadius = 10; // Default radius in kilometers
    public $userType = 'store'; // Default search type: 'store' or 'mechanic'
    public $searchResults = [];
    public $isSearching = false;
    public $errorMessage = '';
    public $showMap = false;

    // User's saved address
    public $address;
    public $isSavingLocation = false;

    public function mount()
    {
        $user = Auth::user();
        $this->latitude = $user->latitude;
        $this->longitude = $user->longitude;
        $this->address = $user->address;
    }

    public function detectLocation()
    {
        $this->emit('getLocation');
    }

    public function updateLocation($lat, $lng, $address = null)
    {
        $this->latitude = $lat;
        $this->longitude = $lng;

        if ($address) {
            $this->address = $address;
        }

        $this->search();
    }

    public function search()
    {
        $this->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'searchRadius' => 'required|numeric|min:1|max:100',
            'userType' => 'required|in:store,mechanic',
        ]);

        $this->isSearching = true;
        $this->errorMessage = '';

        try {
            // Calculate the distance using the Haversine formula in a raw query
            $this->searchResults = User::select(DB::raw('*,
                    ( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance'))
                ->having('distance', '<=', $this->searchRadius)
                ->orderBy('distance')
                ->where('role', $this->userType)
                ->where('id', '!=', Auth::id()) // Exclude current user
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->setBindings([$this->latitude, $this->longitude, $this->latitude])
                ->get();

            $this->showMap = true;

        } catch (\Exception $e) {
            $this->errorMessage = 'An error occurred while searching: ' . $e->getMessage();
        }

        $this->isSearching = false;
    }

    public function saveUserLocation()
    {
        $this->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'address' => 'required|string|max:255',
        ]);

        $this->isSavingLocation = true;

        try {
            $user = Auth::user();
            $user->update([
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'address' => $this->address,
            ]);

            $this->emit('alert', 'success', 'Your location has been saved successfully!');

        } catch (\Exception $e) {
            $this->emit('alert', 'error', 'An error occurred while saving your location: ' . $e->getMessage());
        }

        $this->isSavingLocation = false;
    }

    public function render()
    {
        return view('livewire.mechanical.location-finder')->layout('layouts.app');
    }
}
