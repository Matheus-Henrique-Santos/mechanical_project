<?php

namespace App\Livewire\Mechanical;

use App\Models\Product;
use App\Models\Quote;
use App\Models\QuoteItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Reporting extends Component
{
    public $reportType = 'quote_summary';
    public $dateRange = 'month';
    public $chartData = [];
    public $tableData = [];
    public $customStartDate;
    public $customEndDate;
    public $isGenerating = false;
    public $reportTitle = '';

    protected $listeners = ['refreshReport' => 'generateReport'];

    public function mount()
    {
        // Set default date range
        $this->customStartDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->customEndDate = Carbon::now()->endOfMonth()->format('Y-m-d');

        // Generate initial report
        $this->generateReport();
    }

    public function updatedReportType()
    {
        $this->generateReport();
    }

    public function updatedDateRange()
    {
        if ($this->dateRange === 'custom') {
            return;
        }

        $this->generateReport();
    }

    public function generateCustomReport()
    {
        $this->validate([
            'customStartDate' => 'required|date',
            'customEndDate' => 'required|date|after_or_equal:customStartDate',
        ]);

        $this->generateReport();
    }

    public function generateReport()
    {
        $this->isGenerating = true;

        // Set date range
        $startDate = null;
        $endDate = null;

        switch ($this->dateRange) {
            case 'week':
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
                break;
            case 'month':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;
            case 'quarter':
                $startDate = Carbon::now()->startOfQuarter();
                $endDate = Carbon::now()->endOfQuarter();
                break;
            case 'year':
                $startDate = Carbon::now()->startOfYear();
                $endDate = Carbon::now()->endOfYear();
                break;
            case 'custom':
                $startDate = Carbon::parse($this->customStartDate)->startOfDay();
                $endDate = Carbon::parse($this->customEndDate)->endOfDay();
                break;
            default:
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
        }

        // Generate report based on type
        switch ($this->reportType) {
            case 'quote_summary':
                $this->generateQuoteSummaryReport($startDate, $endDate);
                break;
            case 'revenue_analysis':
                $this->generateRevenueAnalysisReport($startDate, $endDate);
                break;
            case 'product_performance':
                $this->generateProductPerformanceReport($startDate, $endDate);
                break;
            case 'client_analytics':
                $this->generateClientAnalyticsReport($startDate, $endDate);
                break;
            case 'inventory_turnover':
                $this->generateInventoryTurnoverReport($startDate, $endDate);
                break;
            default:
                $this->generateQuoteSummaryReport($startDate, $endDate);
        }

        $this->isGenerating = false;
    }

    // Quote Summary Report
    private function generateQuoteSummaryReport($startDate, $endDate)
    {
        $this->reportTitle = 'Quote Summary Report';
        $user = Auth::user();

        // Apply role-based filtering
        $quoteQuery = Quote::whereBetween('created_at', [$startDate, $endDate]);

        if ($user->role === 'mechanic') {
            $quoteQuery->where('mechanic_id', $user->id);
        } elseif ($user->role === 'client') {
            $quoteQuery->where('client_id', $user->id);
        } elseif ($user->role === 'store') {
            $quoteQuery->whereHas('items', function ($query) use ($user) {
                $query->where('store_id', $user->id);
            });
        }

        // Count quotes by status
        $quotesByStatus = $quoteQuery->get()
            ->groupBy('status')
            ->map(function ($quotes) {
                return count($quotes);
            });

        // Calculate total amounts by status
        $amountsByStatus = $quoteQuery->get()
            ->groupBy('status')
            ->map(function ($quotes) {
                return $quotes->sum('total_amount');
            });

        // Format data for chart
        $statusLabels = [
            'draft' => 'Draft',
            'pending_store' => 'Pending Store',
            'pending_client' => 'Pending Client',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'completed' => 'Completed'
        ];

        $chartData = [
            'labels' => [],
            'datasets' => [
                [
                    'label' => 'Number of Quotes',
                    'data' => []
                ]
            ]
        ];

        $tableData = [];

        foreach ($statusLabels as $status => $label) {
            $count = $quotesByStatus->get($status, 0);
            $amount = $amountsByStatus->get($status, 0);

            $chartData['labels'][] = $label;
            $chartData['datasets'][0]['data'][] = $count;

            $tableData[] = [
                'status' => $label,
                'count' => $count,
                'amount' => $amount
            ];
        }

        // Add total row
        $tableData[] = [
            'status' => 'Total',
            'count' => $quotesByStatus->sum(),
            'amount' => $amountsByStatus->sum()
        ];

        $this->chartData = $chartData;
        $this->tableData = $tableData;
    }

    // Revenue Analysis Report
    private function generateRevenueAnalysisReport($startDate, $endDate)
    {
        $this->reportTitle = 'Revenue Analysis Report';
        $user = Auth::user();

        // Get date range intervals
        $interval = $this->getDateInterval($startDate, $endDate);

        // Apply role-based filtering
        $quoteQuery = Quote::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'approved');

        if ($user->role === 'mechanic') {
            $quoteQuery->where('mechanic_id', $user->id);
        } elseif ($user->role === 'client') {
            $quoteQuery->where('client_id', $user->id);
        } elseif ($user->role === 'store') {
            $quoteQuery->whereHas('items', function ($query) use ($user) {
                $query->where('store_id', $user->id);
            });
        }

        // Get quotes
        $quotes = $quoteQuery->get();

        // Group by interval
        $quotesByInterval = [];
        $dateFormat = $this->getDateFormat($interval);

        foreach ($quotes as $quote) {
            $intervalKey = $quote->created_at->format($dateFormat);

            if (!isset($quotesByInterval[$intervalKey])) {
                $quotesByInterval[$intervalKey] = [
                    'count' => 0,
                    'amount' => 0
                ];
            }

            $quotesByInterval[$intervalKey]['count']++;

            // For stores, only count items they provided
            if ($user->role === 'store') {
                $storeItems = $quote->items()->where('store_id', $user->id)->get();
                $quotesByInterval[$intervalKey]['amount'] += $storeItems->sum('total_price');
            } else {
                $quotesByInterval[$intervalKey]['amount'] += $quote->total_amount;
            }
        }

        // Fill in missing intervals
        $intervalLabels = [];
        $current = clone $startDate;

        while ($current <= $endDate) {
            $intervalKey = $current->format($dateFormat);
            $intervalLabels[$intervalKey] = $this->formatIntervalLabel($current, $interval);

            if (!isset($quotesByInterval[$intervalKey])) {
                $quotesByInterval[$intervalKey] = [
                    'count' => 0,
                    'amount' => 0
                ];
            }

            $this->incrementDateByInterval($current, $interval);
        }

        // Sort by interval key
        ksort($quotesByInterval);

        // Format data for chart
        $chartData = [
            'labels' => array_values($intervalLabels),
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => array_map(function ($data) {
                        return $data['amount'];
                    }, $quotesByInterval)
                ]
            ]
        ];

        // Format data for table
        $tableData = [];

        foreach ($quotesByInterval as $interval => $data) {
            $tableData[] = [
                'interval' => $intervalLabels[$interval],
                'count' => $data['count'],
                'amount' => $data['amount']
            ];
        }

        // Add total row
        $tableData[] = [
            'interval' => 'Total',
            'count' => array_sum(array_column($quotesByInterval, 'count')),
            'amount' => array_sum(array_column($quotesByInterval, 'amount'))
        ];

        $this->chartData = $chartData;
        $this->tableData = $tableData;
    }

    // Product Performance Report
    private function generateProductPerformanceReport($startDate, $endDate)
    {
        $this->reportTitle = 'Product Performance Report';
        $user = Auth::user();

        // For stores, only show their products
        if ($user->role === 'store') {
            // Get products in approved quotes
            $productItems = QuoteItem::whereHas('quote', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate])
                    ->where('status', 'approved');
            })
                ->where('item_type', 'product')
                ->where('store_id', $user->id)
                ->get();

            // Group by product
            $productPerformance = [];

            foreach ($productItems as $item) {
                $productId = $item->product_id;
                $productName = $item->name;

                if (!isset($productPerformance[$productId])) {
                    $productPerformance[$productId] = [
                        'name' => $productName,
                        'quantity' => 0,
                        'revenue' => 0
                    ];
                }

                $productPerformance[$productId]['quantity'] += $item->quantity;
                $productPerformance[$productId]['revenue'] += $item->total_price;
            }

            // Sort by revenue (descending)
            uasort($productPerformance, function ($a, $b) {
                return $b['revenue'] <=> $a['revenue'];
            });

            // Take top 10 products
            $topProducts = array_slice($productPerformance, 0, 10, true);

            // Format data for chart
            $chartData = [
                'labels' => array_keys($topProducts),
                'datasets' => [
                    [
                        'label' => 'Revenue',
                        'data' => array_map(function ($product) {
                            return $product['revenue'];
                        }, $topProducts)
                    ]
                ]
            ];

            // Format data for table
            $tableData = [];

            foreach ($topProducts as $productName => $data) {
                $tableData[] = [
                    'product' => $productName,
                    'store' => $data['store'],
                    'quantity' => $data['quantity'],
                    'revenue' => $data['revenue']
                ];
            }
        }

        $this->chartData = $chartData;
        $this->tableData = $tableData;
    }

    // Client Analytics Report
    private function generateClientAnalyticsReport($startDate, $endDate)
    {
        $this->reportTitle = 'Client Analytics Report';
        $user = Auth::user();

        // This report is primarily for mechanics and stores
        if ($user->role === 'client') {
            $this->chartData = [];
            $this->tableData = [];
            return;
        }

        // Get quotes in date range
        $quoteQuery = Quote::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'approved');

        if ($user->role === 'mechanic') {
            $quoteQuery->where('mechanic_id', $user->id);
        } elseif ($user->role === 'store') {
            $quoteQuery->whereHas('items', function ($query) use ($user) {
                $query->where('store_id', $user->id);
            });
        }

        $quotes = $quoteQuery->with('client')->get();

        // Group by client
        $clientAnalytics = [];

        foreach ($quotes as $quote) {
            $clientId = $quote->client_id;
            $clientName = $quote->client->name;

            if (!isset($clientAnalytics[$clientId])) {
                $clientAnalytics[$clientId] = [
                    'name' => $clientName,
                    'quotes_count' => 0,
                    'total_amount' => 0
                ];
            }

            $clientAnalytics[$clientId]['quotes_count']++;

            // For stores, only count items they provided
            if ($user->role === 'store') {
                $storeItems = $quote->items()->where('store_id', $user->id)->get();
                $clientAnalytics[$clientId]['total_amount'] += $storeItems->sum('total_price');
            } else {
                $clientAnalytics[$clientId]['total_amount'] += $quote->total_amount;
            }
        }

        // Sort by total amount (descending)
        uasort($clientAnalytics, function ($a, $b) {
            return $b['total_amount'] <=> $a['total_amount'];
        });

        // Take top 10 clients
        $topClients = array_slice($clientAnalytics, 0, 10, true);

        // Format data for chart
        $chartData = [
            'labels' => array_map(function ($client) {
                return $client['name'];
            }, $topClients),
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => array_map(function ($client) {
                        return $client['total_amount'];
                    }, $topClients)
                ]
            ]
        ];

        // Format data for table
        $tableData = [];

        foreach ($topClients as $clientId => $data) {
            $tableData[] = [
                'client' => $data['name'],
                'quotes_count' => $data['quotes_count'],
                'total_amount' => $data['total_amount']
            ];
        }

        $this->chartData = $chartData;
        $this->tableData = $tableData;
    }

    // Inventory Turnover Report
    private function generateInventoryTurnoverReport($startDate, $endDate)
    {
        $this->reportTitle = 'Inventory Turnover Report';
        $user = Auth::user();

        // This report is only for stores
        if ($user->role !== 'store') {
            $this->chartData = [];
            $this->tableData = [];
            return;
        }

        // Get products from this store
        $products = Product::where('store_id', $user->id)->get();

        // Get items in approved quotes
        $quoteItems = QuoteItem::whereHas('quote', function ($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate])
                ->where('status', 'approved');
        })
            ->where('item_type', 'product')
            ->where('store_id', $user->id)
            ->get();

        // Calculate turnover for each product
        $productTurnover = [];

        foreach ($products as $product) {
            $productId = $product->id;
            $productName = $product->name;
            $currentStock = $product->stock_quantity;

            // Get sold quantity
            $soldItems = $quoteItems->where('product_id', $productId);
            $soldQuantity = $soldItems->sum('quantity');

            // Calculate turnover rate
            $turnoverRate = $currentStock > 0 ? $soldQuantity / $currentStock : 0;

            $productTurnover[$productId] = [
                'name' => $productName,
                'current_stock' => $currentStock,
                'sold_quantity' => $soldQuantity,
                'turnover_rate' => $turnoverRate
            ];
        }

        // Sort by turnover rate (descending)
        uasort($productTurnover, function ($a, $b) {
            return $b['turnover_rate'] <=> $a['turnover_rate'];
        });

        // Take top 10 products
        $topProducts = array_slice($productTurnover, 0, 10, true);

        // Format data for chart
        $chartData = [
            'labels' => array_map(function ($product) {
                return $product['name'];
            }, $topProducts),
            'datasets' => [
                [
                    'label' => 'Turnover Rate',
                    'data' => array_map(function ($product) {
                        return $product['turnover_rate'];
                    }, $topProducts)
                ]
            ]
        ];

        // Format data for table
        $tableData = [];

        foreach ($topProducts as $productId => $data) {
            $tableData[] = [
                'product' => $data['name'],
                'current_stock' => $data['current_stock'],
                'sold_quantity' => $data['sold_quantity'],
                'turnover_rate' => number_format($data['turnover_rate'], 2)
            ];
        }

        $this->chartData = $chartData;
        $this->tableData = $tableData;
    }

    // Helper methods for date intervals
    private function getDateInterval($startDate, $endDate)
    {
        $diffInDays = $startDate->diffInDays($endDate);

        if ($diffInDays <= 31) {
            return 'day';
        } elseif ($diffInDays <= 92) {
            return 'week';
        } elseif ($diffInDays <= 365) {
            return 'month';
        } else {
            return 'quarter';
        }
    }

    private function getDateFormat($interval)
    {
        switch ($interval) {
            case 'day':
                return 'Y-m-d';
            case 'week':
                return 'Y-W';
            case 'month':
                return 'Y-m';
            case 'quarter':
                return 'Y-n';
            default:
                return 'Y-m-d';
        }
    }

    private function formatIntervalLabel($date, $interval)
    {
        switch ($interval) {
            case 'day':
                return $date->format('M d');
            case 'week':
                return 'Week ' . $date->format('W, Y');
            case 'month':
                return $date->format('M Y');
            case 'quarter':
                $quarter = ceil($date->format('n') / 3);
                return 'Q' . $quarter . ' ' . $date->format('Y');
            default:
                return $date->format('M d, Y');
        }
    }

    private function incrementDateByInterval(&$date, $interval)
    {
        switch ($interval) {
            case 'day':
                $date->addDay();
                break;
            case 'week':
                $date->addWeek();
                break;
            case 'month':
                $date->addMonth();
                break;
            case 'quarter':
                $date->addMonths(3);
                break;
            default:
                $date->addDay();
        }
    }

    public function render()
    {
        return view('livewire.mechanical.reporting')->layout('layouts.app');
    }
}
