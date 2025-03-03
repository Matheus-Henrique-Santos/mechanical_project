<div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-semibold text-gray-900">Appointments</h1>
                <button
                    wire:click="createAppointment"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Schedule Appointment
                </button>
            </div>

            <!-- Filters -->
            <div class="mt-6 md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0 flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4">
                    <div class="w-full lg:max-w-xs">
                        <label for="search" class="sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input
                                wire:model.debounce.300ms="search"
                                id="search"
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                placeholder="Search clients or mechanics..."
                                type="search"
                            >
                        </div>
                    </div>

                    <div class="flex space-x-2">
                        <select
                            wire:model="statusFilter"
                            class="block pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                        >
                            <option value="all">All Status</option>
                            <option value="scheduled">Scheduled</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>

                        <input
                            wire:model="dateFilter"
                            type="date"
                            class="block pl-3 pr-3 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                        >

                        @if(isset($dateFilter))
                            <button
                                wire:click="$set('dateFilter', '')"
                                class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                Clear Date
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            @if($isCreating || $isEditing)
                <!-- Appointment Form -->
                <div class="mt-6 bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            {{ $isEditing ? 'Edit Appointment' : 'Schedule New Appointment' }}
                        </h3>

                        <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <!-- Client Selection -->
                            <div class="sm:col-span-3">
                                <label for="clientId" class="block text-sm font-medium text-gray-700">Client</label>
                                <div class="mt-1">
                                    <select
                                        wire:model="clientId"
                                        id="clientId"
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                        {{ Auth::user()->role === 'client' ? 'disabled' : '' }}
                                    >
                                        <option value="">Select Client</option>
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('clientId') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Mechanic Selection -->
                            <div class="sm:col-span-3">
                                <label for="mechanicId" class="block text-sm font-medium text-gray-700">Mechanic</label>
                                <div class="mt-1">
                                    <select
                                        wire:model="mechanicId"
                                        id="mechanicId"
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                        {{ Auth::user()->role === 'mechanic' ? 'disabled' : '' }}
                                    >
                                        <option value="">Select Mechanic</option>
                                        @foreach($mechanics as $mechanic)
                                            <option value="{{ $mechanic->id }}">{{ $mechanic->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('mechanicId') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Related Quote -->
                            <div class="sm:col-span-3">
                                <label for="quoteId" class="block text-sm font-medium text-gray-700">Related Quote</label>
                                <div class="mt-1">
                                    <select
                                        wire:model="quoteId"
                                        id="quoteId"
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                        <option value="">None</option>
                                        @foreach($quotes as $quote)
                                            <option value="{{ $quote->id }}">Quote #{{ $quote->id }} - {{ $quote->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Duration -->
                            <div class="sm:col-span-3">
                                <label for="duration" class="block text-sm font-medium text-gray-700">Duration (minutes)</label>
                                <div class="mt-1">
                                    <select
                                        wire:model="duration"
                                        id="duration"
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                    >
                                        <option value="30">30 minutes</option>
                                        <option value="60">1 hour</option>
                                        <option value="90">1.5 hours</option>
                                        <option value="120">2 hours</option>
                                        <option value="180">3 hours</option>
                                        <option value="240">4 hours</option>
                                    </select>
                                    @error('duration') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Date and Time -->
                            <div class="sm:col-span-3">
                                <label for="scheduledAt" class="block text-sm font-medium text-gray-700">Date & Time</label>
                                <div class="mt-1 flex">
                                    <input
                                        type="text"
                                        wire:model="scheduledAt"
                                        id="scheduledAt"
                                        readonly
                                        placeholder="Select date and time"
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                    >
                                    <button
                                        type="button"
                                        wire:click="openCalendar"
                                        class="ml-2 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    >
                                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Schedule
                                    </button>
                                </div>
                                @error('scheduledAt') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Status (only for editing) -->
                            @if($isEditing)
                                <div class="sm:col-span-3">
                                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                    <div class="mt-1">
                                        <select
                                            wire:model="status"
                                            id="status"
                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                        >
                                            <option value="scheduled">Scheduled</option>
                                            <option value="in_progress">In Progress</option>
                                            <option value="completed">Completed</option>
                                            <option value="cancelled">Cancelled</option>
                                        </select>
                                        @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            @endif

                            <!-- Notes -->
                            <div class="sm:col-span-6">
                                <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                                <div class="mt-1">
                                    <textarea
                                        wire:model.defer="notes"
                                        id="notes"
                                        rows="3"
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                        placeholder="Any special instructions or notes for this appointment"
                                    ></textarea>
                                    @error('notes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <button
                                wire:click="cancelEdit"
                                type="button"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                Cancel
                            </button>
                            <button
                                wire:click="saveAppointment"
                                type="button"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                {{ $isEditing ? 'Update' : 'Schedule' }} Appointment
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <!-- Appointments List -->
                <div class="mt-6 flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Client / Mechanic
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date & Time
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Duration
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Related Quote
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($appointments as $appointment)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    @if(Auth::user()->role === 'client')
                                                        <div>
                                                            <div class="text-sm font-medium text-gray-900">{{ $appointment->mechanic->name }}</div>
                                                            <div class="text-sm text-gray-500">Mechanic</div>
                                                        </div>
                                                    @elseif(Auth::user()->role === 'mechanic')
                                                        <div>
                                                            <div class="text-sm font-medium text-gray-900">{{ $appointment->client->name }}</div>
                                                            <div class="text-sm text-gray-500">Client</div>
                                                        </div>
                                                    @else
                                                        <div>
                                                            <div class="text-sm font-medium text-gray-900">{{ $appointment->client->name }}</div>
                                                            <div class="text-sm text-gray-500">Client</div>
                                                            <div class="text-sm font-medium text-gray-900 mt-2">{{ $appointment->mechanic->name }}</div>
                                                            <div class="text-sm text-gray-500">Mechanic</div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $appointment->scheduled_at->format('M d, Y') }}</div>
                                                <div class="text-sm text-gray-500">{{ $appointment->scheduled_at->format('H:i') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $appointment->duration_minutes }} minutes
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($appointment->quote)
                                                    <a href="{{ route('quotes.show', $appointment->quote) }}" class="text-indigo-600 hover:text-indigo-900">
                                                        Quote #{{ $appointment->quote->id }}
                                                    </a>
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                        {{ $appointment->status === 'scheduled' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                        {{ $appointment->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : '' }}
                                                        {{ $appointment->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                                        {{ $appointment->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                                    ">
                                                        {{ ucfirst(str_replace('_', ' ', $appointment->status)) }}
                                                    </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <button
                                                        wire:click="editAppointment({{ $appointment->id }})"
                                                        class="text-indigo-600 hover:text-indigo-900"
                                                    >
                                                        Edit
                                                    </button>

                                                    @if($appointment->status === 'scheduled')
                                                        <button
                                                            wire:click="updateAppointmentStatus({{ $appointment->id }}, 'in_progress')"
                                                            class="text-blue-600 hover:text-blue-900"
                                                        >
                                                            Start
                                                        </button>
                                                    @endif

                                                    @if($appointment->status === 'in_progress')
                                                        <button
                                                            wire:click="updateAppointmentStatus({{ $appointment->id }}, 'completed')"
                                                            class="text-green-600 hover:text-green-900"
                                                        >
                                                            Complete
                                                        </button>
                                                    @endif

                                                    @if(in_array($appointment->status, ['scheduled', 'in_progress']))
                                                        <button
                                                            wire:click="updateAppointmentStatus({{ $appointment->id }}, 'cancelled')"
                                                            class="text-red-600 hover:text-red-900"
                                                        >
                                                            Cancel
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                                No appointments found. Click "Schedule Appointment" to create one.
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    {{ $appointments->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Calendar Modal -->
    @if($showCalendar)
        <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Select Date and Time
                        </h3>

                        <!-- Calendar -->
                        <div class="mt-4">
                            <div class="mb-4">
                                <div x-data="{
                                selectedDate: @entangle('selectedDate'),
                                currentMonth: '',
                                currentYear: '',
                                dayNames: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                                days: [],
                                initCalendar() {
                                    const today = new Date();
                                    if (!this.selectedDate) {
                                        this.selectedDate = today.toISOString().split('T')[0];
                                    }

                                    const date = this.selectedDate ? new Date(this.selectedDate) : today;
                                    this.currentMonth = date.getMonth();
                                    this.currentYear = date.getFullYear();
                                    this.updateDays();
                                },
                                updateDays() {
                                    const firstDay = new Date(this.currentYear, this.currentMonth, 1);
                                    const lastDay = new Date(this.currentYear, this.currentMonth + 1, 0);
                                    const daysInMonth = lastDay.getDate();
                                    const startingDayOfWeek = firstDay.getDay();

                                    const days = [];

                                    // Add empty days for previous month
                                    for (let i = 0; i < startingDayOfWeek; i++) {
                                        days.push({ day: '', date: null });
                                    }

                                    // Add days for current month
                                    for (let i = 1; i <= daysInMonth; i++) {
                                        const date = new Date(this.currentYear, this.currentMonth, i);
                                        const dateStr = date.toISOString().split('T')[0];
                                        days.push({
                                            day: i,
                                            date: dateStr,
                                            isToday: dateStr === new Date().toISOString().split('T')[0],
                                            isSelected: dateStr === this.selectedDate,
                                            isPast: date < new Date(new Date().setHours(0, 0, 0, 0))
                                        });
                                    }

                                    this.days = days;
                                },
                                prevMonth() {
                                    if (this.currentMonth === 0) {
                                        this.currentMonth = 11;
                                        this.currentYear--;
                                    } else {
                                        this.currentMonth--;
                                    }
                                    this.updateDays();
                                },
                                nextMonth() {
                                    if (this.currentMonth === 11) {
                                        this.currentMonth = 0;
                                        this.currentYear++;
                                    } else {
                                        this.currentMonth++;
                                    }
                                    this.updateDays();
                                },
                                selectDate(dateStr) {
                                    if (!dateStr) return;
                                    const date = new Date(dateStr);
                                    if (date < new Date(new Date().setHours(0, 0, 0, 0))) return;

                                    this.selectedDate = dateStr;
                                    this.updateDays();
                                    $wire.dateSelected(dateStr);
                                },
                                formatMonth() {
                                    const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                                    return months[this.currentMonth] + ' ' + this.currentYear;
                                }
                            }" x-init="initCalendar()" class="bg-white rounded-lg">
                                    <div class="flex items-center justify-between mb-4">
                                        <button
                                            type="button"
                                            @click="prevMonth"
                                            class="inline-flex items-center p-1 rounded-full hover:bg-gray-100 focus:outline-none"
                                        >
                                            <svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                            </svg>
                                        </button>
                                        <div class="text-lg font-semibold" x-text="formatMonth()"></div>
                                        <button
                                            type="button"
                                            @click="nextMonth"
                                            class="inline-flex items-center p-1 rounded-full hover:bg-gray-100 focus:outline-none"
                                        >
                                            <svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="grid grid-cols-7 gap-2 mb-2">
                                        <template x-for="dayName in dayNames">
                                            <div class="text-center text-xs font-medium text-gray-500 py-1" x-text="dayName"></div>
                                        </template>
                                    </div>
                                    <div class="grid grid-cols-7 gap-2">
                                        <template x-for="(day, index) in days" :key="index">
                                            <div
                                                @click="selectDate(day.date)"
                                                :class="{
                                                'cursor-pointer hover:bg-indigo-50': day.date && !day.isPast,
                                                'bg-indigo-100 text-indigo-800': day.isSelected,
                                                'bg-gray-100': day.isToday && !day.isSelected,
                                                'text-gray-400': day.isPast,
                                                'cursor-not-allowed': day.isPast
                                            }"
                                                class="text-center text-sm py-2 rounded-md"
                                            >
                                                <span x-text="day.day"></span>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <!-- Time Slots -->
                            <div class="mt-6">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Available Time Slots</h4>

                                @if(count($availableTimeSlots) > 0)
                                    <div class="grid grid-cols-3 gap-2">
                                        @foreach($availableTimeSlots as $time)
                                            <button
                                                wire:click="timeSelected('{{ $time }}')"
                                                class="py-2 px-3 text-sm border border-gray-300 rounded-md text-center hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                            >
                                                {{ $time }}
                                            </button>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500 text-center py-4">
                                        No available time slots for this date. Please select another date.
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button
                            wire:click="$set('showCalendar', false)"
                            type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm"
                        >
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
