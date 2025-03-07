<div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-semibold text-gray-900 mb-6">Reports & Analytics</h1>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                <div class="px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-2">
                            <label for="reportType" class="block text-sm font-medium text-gray-700">Report Type</label>
                            <div class="mt-1">
                                <select
                                    wire:model="reportType"
                                    id="reportType"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                >
                                    <option value="quote_summary">Quote Summary</option>
                                    <option value="revenue_analysis">Revenue Analysis</option>
                                    <option value="product_performance">Product Performance</option>
                                    <option value="client_analytics">Client Analytics</option>

                                    @if(Auth::user()->role === 'store')
                                        <option value="inventory_turnover">Inventory Turnover</option>
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="dateRange" class="block text-sm font-medium text-gray-700">Date Range</label>
                            <div class="mt-1">
                                <select
                                    wire:model="dateRange"
                                    id="dateRange"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                >
                                    <option value="week">Current Week</option>
                                    <option value="month">Current Month</option>
                                    <option value="quarter">Current Quarter</option>
                                    <option value="year">Current Year</option>
                                    <option value="custom">Custom Range</option>
                                </select>
                            </div>
                        </div>

                        @if($dateRange === 'custom')
                            <div class="sm:col-span-2">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="customStartDate" class="block text-sm font-medium text-gray-700">Start Date</label>
                                        <div class="mt-1">
                                            <input
                                                type="date"
                                                wire:model.defer="customStartDate"
                                                id="customStartDate"
                                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                            >
                                            @error('customStartDate') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div>
                                        <label for="customEndDate" class="block text-sm font-medium text-gray-700">End Date</label>
                                        <div class="mt-1">
                                            <input
                                                type="date"
                                                wire:model.defer="customEndDate"
                                                id="customEndDate"
                                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                            >
                                            @error('customEndDate') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="sm:col-span-6 flex justify-end">
                                <button
                                    wire:click="generateCustomReport"
                                    wire:loading.attr="disabled"
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >
                                    <svg wire:loading wire:target="generateCustomReport" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Generate Report
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Report Content -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ $reportTitle }}</h3>

                    <div wire:loading wire:target="generateReport, updatedReportType, updatedDateRange, generateCustomReport">
                        <div class="flex justify-center items-center py-8">
                            <svg class="animate-spin h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="ml-2 text-gray-600">Generating report...</span>
                        </div>
                    </div>

                    <div wire:loading.remove wire:target="generateReport, updatedReportType, updatedDateRange, generateCustomReport">
                        @if(count($chartData) > 0)
                            <!-- Chart Section -->
                            <div class="mb-6">
                                <div class="bg-gray-50 p-4 rounded-lg" style="height: 400px;" id="reportChart"></div>
                            </div>

                            <!-- Table Section -->
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        @if($reportType === 'quote_summary')
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Count</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                        @elseif($reportType === 'revenue_analysis')
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Period</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quotes</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
                                        @elseif($reportType === 'product_performance')
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                            @if(Auth::user()->role !== 'store')
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Store</th>
                                            @endif
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
                                        @elseif($reportType === 'client_analytics')
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quotes</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Spent</th>
                                        @elseif($reportType === 'inventory_turnover')
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current Stock</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sold Quantity</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Turnover Rate</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($tableData as $index => $row)
                                        <tr class="{{ $index === count($tableData) - 1 ? 'bg-gray-50 font-semibold' : '' }}">
                                            @if($reportType === 'quote_summary')
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $row['status'] }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $row['count'] }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">R$ {{ number_format($row['amount'], 2, ',', '.') }}</td>
                                            @elseif($reportType === 'revenue_analysis')
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $row['interval'] }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $row['count'] }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">R$ {{ number_format($row['amount'], 2, ',', '.') }}</td>
                                            @elseif($reportType === 'product_performance')
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $row['product'] }}</td>
                                                @if(Auth::user()->role !== 'store')
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $row['store'] }}</td>
                                                @endif
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $row['quantity'] }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">R$ {{ number_format($row['revenue'], 2, ',', '.') }}</td>
                                            @elseif($reportType === 'client_analytics')
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $row['client'] }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $row['quotes_count'] }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">R$ {{ number_format($row['total_amount'], 2, ',', '.') }}</td>
                                            @elseif($reportType === 'inventory_turnover')
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $row['product'] }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $row['current_stock'] }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $row['sold_quantity'] }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $row['turnover_rate'] }}</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                @if(Auth::user()->role === 'client' && in_array($reportType, ['client_analytics', 'inventory_turnover']))
                                    <p>This report is not available for clients.</p>
                                @elseif(Auth::user()->role !== 'store' && $reportType === 'inventory_turnover')
                                    <p>Inventory turnover reports are only available for stores.</p>
                                @else
                                    <p>No data available for the selected filters.</p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Chart Rendering -->
    @if(count($chartData) > 0)
        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('livewire:load', function() {
                    renderChart(@json($chartData));

                    Livewire.on('chartDataUpdated', function(chartData) {
                        renderChart(chartData);
                    });

                    function renderChart(chartData) {
                        const ctx = document.getElementById('reportChart').getContext('2d');

                        // Destroy previous chart if it exists
                        if (window.reportChart) {
                            window.reportChart.destroy();
                        }

                        // Determine chart type based on report type
                        let chartType = 'bar';
                        let chartOptions = {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let label = context.dataset.label || '';
                                            if (label) {
                                                label += ': ';
                                            }

                                            if (@json($reportType) === 'inventory_turnover') {
                                                label += context.raw.toFixed(2);
                                            } else {
                                                label += 'R$ ' + context.raw.toLocaleString('pt-BR', { minimumFractionDigits: 2 });
                                            }

                                            return label;
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function(value) {
                                            if (@json($reportType) === 'inventory_turnover') {
                                                return value.toFixed(2);
                                            } else if (@json($reportType) === 'quote_summary') {
                                                return value;
                                            } else {
                                                return 'R$ ' + value.toLocaleString('pt-BR', { minimumFractionDigits: 2 });
                                            }
                                        }
                                    }
                                }
                            }
                        };

                        if (@json($reportType) === 'revenue_analysis') {
                            chartType = 'line';
                            chartOptions.elements = {
                                line: {
                                    tension: 0.2
                                }
                            };
                        }

                        // Set colors
                        const datasets = chartData.datasets.map((dataset, index) => {
                            const colors = [
                                'rgba(59, 130, 246, 0.8)',   // Blue
                                'rgba(16, 185, 129, 0.8)',   // Green
                                'rgba(249, 115, 22, 0.8)',   // Orange
                                'rgba(236, 72, 153, 0.8)'    // Pink
                            ];

                            return {
                                ...dataset,
                                backgroundColor: colors[index % colors.length],
                                borderColor: colors[index % colors.length].replace('0.8', '1'),
                                borderWidth: 1
                            };
                        });

                        // Create chart
                        window.reportChart = new Chart(ctx, {
                            type: chartType,
                            data: {
                                labels: chartData.labels,
                                datasets: datasets
                            },
                            options: chartOptions
                        });
                    }
                });
            </script>
        @endpush
    @endif
</div>
