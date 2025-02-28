<?php

namespace App\Livewire\Mechanical;

use App\Models\Appointment;
use App\Models\Notification;
use App\Models\Quote;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class AppointmentManagement extends Component
{
    use WithPagination;

    // List Properties
    public $search = '';
    public $statusFilter = 'all';
    public $dateFilter = '';

    // Form Properties
    public $appointmentId;
    public $clientId;
    public $mechanicId;
    public $quoteId;
    public $scheduledAt;
    public $duration = 60; // minutes
    public $notes;
    public $status = 'scheduled';

    // UI Properties
    public $isCreating = false;
    public $isEditing = false;
    public $showCalendar = false;
    public $clients = [];
    public $mechanics = [];
    public $quotes = [];
    public $selectedDate;
    public $availableTimeSlots = [];

    // Listeners
    protected $listeners = [
        'refreshAppointments' => '$refresh',
        'dateSelected',
        'timeSelected',
        'updateAppointmentStatus'
    ];

    protected $rules = [
        'clientId' => 'required|exists:users,id',
        'mechanicId' => 'required|exists:users,id',
        'quoteId' => 'nullable|exists:quotes,id',
        'scheduledAt' => 'required|date|after:now',
        'duration' => 'required|integer|min:15|max:480',
        'notes' => 'nullable|string',
        'status' => 'required|in:scheduled,in_progress,completed,cancelled'
    ];

    public function mount($creating = false)
    {
        $this->isCreating = $creating;
        // If mechanic_id or client_id is provided in the URL, pre-select them
        if (request()->has('mechanic_id')) {
            $this->mechanicId = request()->mechanic_id;
        }

        if (request()->has('client_id')) {
            $this->clientId = request()->client_id;
        }

        if (request()->has('quote_id')) {
            $this->quoteId = request()->quote_id;
        }

        // Load users based on role
        $this->loadUsers();
    }

    private function loadUsers()
    {
        $user = Auth::user();

        // Load available mechanics and clients based on user role
        if ($user->role === 'client') {
            $this->clientId = $user->id;
            $this->mechanics = User::where('role', 'mechanic')->get();
        } elseif ($user->role === 'mechanic') {
            $this->mechanicId = $user->id;
            $this->clients = User::where('role', 'client')->get();
        } else {
            $this->clients = User::where('role', 'client')->get();
            $this->mechanics = User::where('role', 'mechanic')->get();
        }
    }

    // Appointment List Functions
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingDateFilter()
    {
        $this->resetPage();
    }

    // Appointment CRUD Functions
    public function createAppointment()
    {
        $this->resetValidation();
        $this->resetForm();
        $this->isCreating = true;
        $this->isEditing = false;

        // Current user is client, pre-select them
        if (Auth::user()->role === 'client') {
            $this->clientId = Auth::id();
        }
        // Current user is mechanic, pre-select them
        elseif (Auth::user()->role === 'mechanic') {
            $this->mechanicId = Auth::id();
        }

        // Load quotes based on selected client and mechanic
        $this->loadQuotes();
    }

    public function editAppointment($appointmentId)
    {
        $this->resetValidation();
        $this->resetForm();

        $appointment = Appointment::findOrFail($appointmentId);

        $this->appointmentId = $appointment->id;
        $this->clientId = $appointment->client_id;
        $this->mechanicId = $appointment->mechanic_id;
        $this->quoteId = $appointment->quote_id;
        $this->scheduledAt = $appointment->scheduled_at->format('Y-m-d H:i');
        $this->duration = $appointment->duration_minutes;
        $this->notes = $appointment->notes;
        $this->status = $appointment->status;

        // Load quotes
        $this->loadQuotes();

        $this->isCreating = false;
        $this->isEditing = true;
    }

    public function saveAppointment()
    {
        $this->validate();

        if ($this->appointmentId) {
            // Update existing appointment
            $appointment = Appointment::findOrFail($this->appointmentId);

            // Check if user has permission to edit
            if (!$this->canManageAppointment($appointment)) {
                $this->emit('alert', 'error', 'You do not have permission to edit this appointment.');
                return;
            }

            $appointment->update([
                'client_id' => $this->clientId,
                'mechanic_id' => $this->mechanicId,
                'quote_id' => $this->quoteId,
                'scheduled_at' => $this->scheduledAt,
                'duration_minutes' => $this->duration,
                'notes' => $this->notes,
                'status' => $this->status,
            ]);

            // Notify users about update
            $this->notifyAppointmentUpdate($appointment);

            $this->emit('alert', 'success', 'Appointment updated successfully!');
        } else {
            // Create new appointment
            $appointment = Appointment::create([
                'client_id' => $this->clientId,
                'mechanic_id' => $this->mechanicId,
                'quote_id' => $this->quoteId,
                'scheduled_at' => $this->scheduledAt,
                'duration_minutes' => $this->duration,
                'notes' => $this->notes,
                'status' => $this->status,
            ]);

            // Notify users about new appointment
            $this->notifyAppointmentCreation($appointment);

            $this->emit('alert', 'success', 'Appointment scheduled successfully!');
        }

        $this->isCreating = false;
        $this->isEditing = false;
    }

    public function cancelEdit()
    {
        $this->isCreating = false;
        $this->isEditing = false;
        $this->resetForm();
    }

    // Calendar Functions
    public function openCalendar()
    {
        $this->showCalendar = true;
        $this->selectedDate = Carbon::now()->format('Y-m-d');
        $this->loadAvailableTimeSlots();
    }

    public function dateSelected($date)
    {
        $this->selectedDate = $date;
        $this->loadAvailableTimeSlots();
    }

    public function timeSelected($time)
    {
        $this->scheduledAt = $this->selectedDate . ' ' . $time;
        $this->showCalendar = false;
    }

    public function loadAvailableTimeSlots()
    {
        if (!$this->mechanicId || !$this->selectedDate) {
            $this->availableTimeSlots = [];
            return;
        }

        $date = Carbon::parse($this->selectedDate);

        // Define working hours (8 AM to 6 PM)
        $startHour = 8;
        $endHour = 18;

        // Generate 30-minute time slots
        $timeSlots = [];

        for ($hour = $startHour; $hour < $endHour; $hour++) {
            for ($minute = 0; $minute < 60; $minute += 30) {
                $time = sprintf('%02d:%02d', $hour, $minute);
                $timeSlots[] = $time;
            }
        }

        // Get mechanic's appointments for the selected date
        $appointments = Appointment::where('mechanic_id', $this->mechanicId)
            ->whereDate('scheduled_at', $date)
            ->whereIn('status', ['scheduled', 'in_progress'])
            ->get();

        // Remove booked time slots
        $availableTimeSlots = [];

        foreach ($timeSlots as $timeSlot) {
            $slotStart = Carbon::parse($this->selectedDate . ' ' . $timeSlot);
            $slotEnd = (clone $slotStart)->addMinutes($this->duration);

            // Check if slot is in the future
            if ($slotStart <= Carbon::now()) {
                continue;
            }

            // Check if slot conflicts with existing appointments
            $isAvailable = true;

            foreach ($appointments as $appointment) {
                $apptStart = Carbon::parse($appointment->scheduled_at);
                $apptEnd = (clone $apptStart)->addMinutes($appointment->duration_minutes);

                // Check for overlap
                if (
                    ($slotStart >= $apptStart && $slotStart < $apptEnd) ||
                    ($slotEnd > $apptStart && $slotEnd <= $apptEnd) ||
                    ($slotStart <= $apptStart && $slotEnd >= $apptEnd)
                ) {
                    $isAvailable = false;
                    break;
                }
            }

            if ($isAvailable) {
                $availableTimeSlots[] = $timeSlot;
            }
        }

        $this->availableTimeSlots = $availableTimeSlots;
    }

    // Status Update Function
    public function updateAppointmentStatus($appointmentId, $newStatus)
    {
        $appointment = Appointment::findOrFail($appointmentId);

        // Check if user has permission to update status
        if (!$this->canManageAppointment($appointment)) {
            $this->emit('alert', 'error', 'You do not have permission to update this appointment status.');
            return;
        }

        $appointment->update(['status' => $newStatus]);

        // Notify users about status change
        $this->notifyStatusChange($appointment, $newStatus);

        $this->emit('alert', 'success', 'Appointment status updated successfully!');
    }

    // Helper Functions
    private function loadQuotes()
    {
        if (!$this->clientId || !$this->mechanicId) {
            $this->quotes = [];
            return;
        }

        // Load approved quotes for the selected client and mechanic
        $this->quotes = Quote::where('client_id', $this->clientId)
            ->where('mechanic_id', $this->mechanicId)
            ->where('status', 'approved')
            ->get();
    }

    private function canManageAppointment($appointment)
    {
        $user = Auth::user();

        // Store users cannot manage appointments
        if ($user->role === 'store') {
            return false;
        }

        // Clients can only manage their own appointments
        if ($user->role === 'client' && $appointment->client_id !== $user->id) {
            return false;
        }

        // Mechanics can only manage appointments where they are the mechanic
        if ($user->role === 'mechanic' && $appointment->mechanic_id !== $user->id) {
            return false;
        }

        return true;
    }

    private function notifyAppointmentCreation($appointment)
    {
        $creator = Auth::user();

        // Notify client (if creator is not the client)
        if ($creator->id !== $appointment->client_id) {
            Notification::create([
                'user_id' => $appointment->client_id,
                'type' => 'new_appointment',
                'message' => "New appointment scheduled on " . Carbon::parse($appointment->scheduled_at)->format('M d, H:i'),
                'notifiable_type' => 'App\Models\Appointment',
                'notifiable_id' => $appointment->id,
            ]);
        }

        // Notify mechanic (if creator is not the mechanic)
        if ($creator->id !== $appointment->mechanic_id) {
            Notification::create([
                'user_id' => $appointment->mechanic_id,
                'type' => 'new_appointment',
                'message' => "New appointment scheduled with " . User::find($appointment->client_id)->name . " on " . Carbon::parse($appointment->scheduled_at)->format('M d, H:i'),
                'notifiable_type' => 'App\Models\Appointment',
                'notifiable_id' => $appointment->id,
            ]);
        }
    }

    private function notifyAppointmentUpdate($appointment)
    {
        $updater = Auth::user();

        // Notify client (if updater is not the client)
        if ($updater->id !== $appointment->client_id) {
            Notification::create([
                'user_id' => $appointment->client_id,
                'type' => 'appointment_updated',
                'message' => "Appointment updated for " . Carbon::parse($appointment->scheduled_at)->format('M d, H:i'),
                'notifiable_type' => 'App\Models\Appointment',
                'notifiable_id' => $appointment->id,
            ]);
        }

        // Notify mechanic (if updater is not the mechanic)
        if ($updater->id !== $appointment->mechanic_id) {
            Notification::create([
                'user_id' => $appointment->mechanic_id,
                'type' => 'appointment_updated',
                'message' => "Appointment with " . User::find($appointment->client_id)->name . " updated for " . Carbon::parse($appointment->scheduled_at)->format('M d, H:i'),
                'notifiable_type' => 'App\Models\Appointment',
                'notifiable_id' => $appointment->id,
            ]);
        }
    }

    private function notifyStatusChange($appointment, $newStatus)
    {
        $updater = Auth::user();

        $statusText = str_replace('_', ' ', ucfirst($newStatus));

        // Notify client (if updater is not the client)
        if ($updater->id !== $appointment->client_id) {
            Notification::create([
                'user_id' => $appointment->client_id,
                'type' => 'appointment_status',
                'message' => "Appointment status changed to {$statusText}",
                'notifiable_type' => 'App\Models\Appointment',
                'notifiable_id' => $appointment->id,
            ]);
        }

        // Notify mechanic (if updater is not the mechanic)
        if ($updater->id !== $appointment->mechanic_id) {
            Notification::create([
                'user_id' => $appointment->mechanic_id,
                'type' => 'appointment_status',
                'message' => "Appointment with " . User::find($appointment->client_id)->name . " status changed to {$statusText}",
                'notifiable_type' => 'App\Models\Appointment',
                'notifiable_id' => $appointment->id,
            ]);
        }
    }

    private function resetForm()
    {
        $this->appointmentId = null;
        $this->scheduledAt = null;
        $this->duration = 60;
        $this->notes = null;
        $this->status = 'scheduled';
        $this->showCalendar = false;

        // Don't reset clientId and mechanicId if pre-selected
        if (!request()->has('client_id')) {
            $this->clientId = Auth::user()->role === 'client' ? Auth::id() : null;
        }

        if (!request()->has('mechanic_id')) {
            $this->mechanicId = Auth::user()->role === 'mechanic' ? Auth::id() : null;
        }

        $this->quoteId = request()->has('quote_id') ? request()->quote_id : null;

        // Reload quotes
        $this->loadQuotes();
    }

    public function updatedClientId()
    {
        $this->loadQuotes();
    }

    public function updatedMechanicId()
    {
        $this->loadQuotes();
    }

    public function render()
    {
        $user = Auth::user();

        $appointmentsQuery = Appointment::query();

        // Apply role-based filters
        if ($user->role === 'mechanic') {
            $appointmentsQuery->where('mechanic_id', $user->id);
        } elseif ($user->role === 'client') {
            $appointmentsQuery->where('client_id', $user->id);
        }

        // Apply search
        if (!empty($this->search)) {
            $appointmentsQuery->where(function ($query) {
                $query->whereHas('client', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })
                    ->orWhereHas('mechanic', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhere('notes', 'like', '%' . $this->search . '%');
            });
        }

        // Apply status filter
        if ($this->statusFilter !== 'all') {
            $appointmentsQuery->where('status', $this->statusFilter);
        }

        // Apply date filter
        if (!empty($this->dateFilter)) {
            $appointmentsQuery->whereDate('scheduled_at', $this->dateFilter);
        }

        // Get appointments with relations
        $appointments = $appointmentsQuery->with(['client', 'mechanic', 'quote'])
            ->orderBy('scheduled_at', 'desc')
            ->paginate(10);

        return view('livewire.mechanical.appointment-management', [
            'appointments' => $appointments,
        ])->layout('layouts.app');
    }
}
