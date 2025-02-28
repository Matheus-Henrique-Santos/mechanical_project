<?php

namespace App\Livewire\Mechanical;

use App\Models\Appointment;
use App\Models\Message;
use App\Models\Product;
use App\Models\Quote;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public $role;
    public $lowStockProducts = [];
    public $expiringBatches = [];
    public $pendingQuotes = [];
    public $upcomingAppointments = [];
    public $unreadMessages = 0;

    public function mount()
    {
        $this->role = Auth::user()->role;
        $this->loadDashboardData();
    }

    public function loadDashboardData()
    {
        if ($this->role === 'store') {
            $this->loadStoreData();
        } elseif ($this->role === 'mechanic') {
            $this->loadMechanicData();
        } else {
            $this->loadClientData();
        }

        // Common data for all user types
        $this->unreadMessages = Message::where('recipient_id', Auth::id())
            ->where('read', false)
            ->count();
    }

    private function loadStoreData()
    {
        // Low stock products
        $this->lowStockProducts = Product::where('store_id', Auth::id())
            ->whereRaw('stock_quantity <= min_stock_level')
            ->take(5)
            ->get();

        // Expiring batches (products expiring in the next 30 days)
        $this->expiringBatches = \App\Models\ProductBatch::whereHas('product', function ($query) {
            $query->where('store_id', Auth::id());
        })
            ->whereNotNull('expiry_date')
            ->whereDate('expiry_date', '<=', now()->addDays(30))
            ->with('product')
            ->take(5)
            ->get();

        // Pending quotes that need store approval
        $this->pendingQuotes = Quote::whereHas('items', function ($query) {
            $query->where('store_id', Auth::id())->where('status', 'pending');
        })
            ->where('status', 'pending_store')
            ->with(['client', 'mechanic'])
            ->take(5)
            ->get();
    }

    private function loadMechanicData()
    {
        // Pending quotes created by this mechanic
        $this->pendingQuotes = Quote::where('mechanic_id', Auth::id())
            ->whereIn('status', ['draft', 'pending_store', 'pending_client'])
            ->with(['client', 'items'])
            ->take(5)
            ->get();

        // Upcoming appointments
        $this->upcomingAppointments = Appointment::where('mechanic_id', Auth::id())
            ->where('status', 'scheduled')
            ->whereDate('scheduled_at', '>=', now())
            ->with('client')
            ->orderBy('scheduled_at')
            ->take(5)
            ->get();
    }

    private function loadClientData()
    {
        // Pending quotes for this client
        $this->pendingQuotes = Quote::where('client_id', Auth::id())
            ->where('status', 'pending_client')
            ->with(['mechanic', 'items'])
            ->take(5)
            ->get();

        // Upcoming appointments
        $this->upcomingAppointments = Appointment::where('client_id', Auth::id())
            ->where('status', 'scheduled')
            ->whereDate('scheduled_at', '>=', now())
            ->with('mechanic')
            ->orderBy('scheduled_at')
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.mechanical.dashboard')->layout('layouts.app');
    }
}
