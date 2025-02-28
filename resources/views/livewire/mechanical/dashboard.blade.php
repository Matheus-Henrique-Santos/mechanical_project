<div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>

            <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
{{--                @if($role === 'store')--}}
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">Low Stock Items</dt>
                            <dd class="mt-1 text-3xl font-semibold text-indigo-600">{{ count($lowStockProducts) }}</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-3">
                            <a href="{{ route('inventory.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View all</a>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">Expiring Batches</dt>
                            <dd class="mt-1 text-3xl font-semibold text-yellow-600">{{ count($expiringBatches) }}</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-3">
                            <a href="{{ route('inventory.batches', ['filter' => 'expiring']) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View all</a>
                        </div>
                    </div>
{{--                @endif--}}

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-sm font-medium text-gray-500 truncate">Pending Quotes</dt>
                        <dd class="mt-1 text-3xl font-semibold text-indigo-600">{{ count($pendingQuotes) }}</dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-3">
                        <a href="{{ route('quotes.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View all</a>
                    </div>
                </div>

{{--                @if($role !== 'store')--}}
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">Upcoming Appointments</dt>
                            <dd class="mt-1 text-3xl font-semibold text-indigo-600">{{ count($upcomingAppointments) }}</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-3">
                            <a href="{{ route('appointments.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View all</a>
                        </div>
                    </div>
{{--                @endif--}}

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-sm font-medium text-gray-500 truncate">Unread Messages</dt>
                        <dd class="mt-1 text-3xl font-semibold text-indigo-600">{{ $unreadMessages }}</dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-3">
                        <a href="{{ route('messages.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View all</a>
                    </div>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-2">
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            {{ $role === 'store' ? 'Pending Quote Approvals' : 'Recent Quotes' }}
                        </h3>
                    </div>
                    <div class="p-4">
                        @if(count($pendingQuotes) > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        @if($role !== 'client')
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                                        @endif
                                        @if($role !== 'mechanic')
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mechanic</th>
                                        @endif
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($pendingQuotes as $quote)
                                        <tr>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $quote->id }}</td>
                                            @if($role !== 'client')
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $quote->client->name }}</td>
                                            @endif
                                            @if($role !== 'mechanic')
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $quote->mechanic->name }}</td>
                                            @endif
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">R$ {{ number_format($quote->total_amount, 2, ',', '.') }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $quote->status === 'pending_client' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                                                    {{ str_replace('_', ' ', ucfirst($quote->status)) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                <a href="{{ route('quotes.show', $quote) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4 text-gray-500">No pending quotes found.</div>
                        @endif
                    </div>
                </div>

{{--                @if($role === 'store')--}}
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Low Stock Products
                            </h3>
                        </div>
                        <div class="p-4">
                            @if(count($lowStockProducts) > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current Stock</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Min Level</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($lowStockProducts as $product)
                                            <tr>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $product->name }}</td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $product->stock_quantity }}</td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $product->min_stock_level }}</td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                    <a href="{{ route('inventory.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900">Update Stock</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4 text-gray-500">No low stock products found.</div>
                            @endif
                        </div>
                    </div>
{{--                @elseif($role !== 'store')--}}
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Upcoming Appointments
                            </h3>
                        </div>
                        <div class="p-4">
                            @if(count($upcomingAppointments) > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                                            @if($role === 'client')
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mechanic</th>
                                            @else
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                                            @endif
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($upcomingAppointments as $appointment)
                                            <tr>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $appointment->scheduled_at->format('d/m/Y H:i') }}
                                                </td>
                                                @if($role === 'client')
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $appointment->mechanic->name }}</td>
                                                @else
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $appointment->client->name }}</td>
                                                @endif
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $appointment->duration_minutes }} min</td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                    <a href="{{ route('appointments.show', $appointment) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4 text-gray-500">No upcoming appointments found.</div>
                            @endif
                        </div>
                    </div>
{{--                @endif--}}
            </div>
        </div>
    </div>
</div>
