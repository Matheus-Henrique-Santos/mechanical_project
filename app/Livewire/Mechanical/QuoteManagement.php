<?php

namespace App\Livewire\Mechanical;

use App\Models\Message;
use App\Models\Notification;
use App\Models\Product;
use App\Models\Quote;
use App\Models\QuoteItem;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class QuoteManagement extends Component
{
    use WithPagination;

    // List Properties
    public $search = '';
    public $statusFilter = 'all';
    public $dateFilter = '';

    // Form Properties
    public $quoteId;
    public $clientId;
    public $title;
    public $description;
    public $validUntil;

    // Items Properties
    public $items = [];
    public $itemType = 'product';
    public $productId;
    public $serviceId;
    public $itemName;
    public $itemQuantity = 1;
    public $itemPrice;
    public $storeId;
    public $stores = [];
    public $availableServices = [];

    // UI Properties
    public $isCreating = false;
    public $isEditing = false;
    public $showItemForm = false;
    public $editingItemIndex = null;
    public $clients = [];
    public $availableProducts = [];
    public $searchProduct = '';
    public $searchService = '';
    public $showMessageModal = false;
    public $messageContent = '';
    public $messageRecipientId;
    public $messageRecipientName;

    // Listeners
    protected $listeners = [
        'refreshQuotes' => '$refresh',
        'productSelected' => 'setSelectedProduct',
        'serviceSelected' => 'setSelectedService',
        'sendMessage',
        'approveItem',
        'rejectItem',
        'approveQuote',
        'rejectQuote'
    ];

    public function mount($creating = false)
    {
        $this->isCreating = $creating;
        // Load clients if user is a mechanic
        if (Auth::user()->role === 'mechanic') {
            $this->clients = User::where('role', 'client')->get();
        }
    }

    // Quote List Functions
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

    // Quote CRUD Functions
    public function createQuote()
    {
        $this->resetValidation();
        $this->resetForm();
        $this->isCreating = true;
        $this->isEditing = false;
    }

    public function editQuote($quoteId)
    {
        $this->resetValidation();
        $this->resetForm();

        $quote = Quote::with('items')->findOrFail($quoteId);

        $this->quoteId = $quote->id;
        $this->clientId = $quote->client_id;
        $this->title = $quote->title;
        $this->description = $quote->description;
        $this->validUntil = $quote->valid_until ? $quote->valid_until->format('Y-m-d') : null;

        // Load items
        foreach ($quote->items as $item) {
            $this->items[] = [
                'id' => $item->id,
                'type' => $item->item_type,
                'product_id' => $item->product_id,
                'name' => $item->name,
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
                'total_price' => $item->total_price,
                'store_id' => $item->store_id,
                'store_name' => $item->store_id ? User::find($item->store_id)->name : null,
                'status' => $item->status
            ];
        }

        $this->isCreating = false;
        $this->isEditing = true;
    }

    public function saveQuote()
    {
        $this->validate([
            'clientId' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'validUntil' => 'nullable|date|after:yesterday',
            'items' => 'required|array|min:1',
        ]);

        $totalAmount = 0;
        foreach ($this->items as $item) {
            $totalAmount += $item['total_price'];
        }

        DB::beginTransaction();
        try {
            if ($this->quoteId) {
                // Update existing quote
                $quote = Quote::findOrFail($this->quoteId);
                $quote->update([
                    'client_id' => $this->clientId,
                    'title' => $this->title,
                    'description' => $this->description,
                    'valid_until' => $this->validUntil,
                    'total_amount' => $totalAmount,
                ]);

                // Delete removed items
                $existingItemIds = collect($this->items)->pluck('id')->filter()->toArray();
                QuoteItem::where('quote_id', $quote->id)
                    ->whereNotIn('id', $existingItemIds)
                    ->delete();

                // Update items
                foreach ($this->items as $item) {
                    if (isset($item['id'])) {
                        // Update existing item
                        QuoteItem::where('id', $item['id'])->update([
                            'item_type' => $item['type'],
                            'product_id' => $item['type'] === 'product' ? $item['product_id'] : null,
                            'name' => $item['name'],
                            'quantity' => $item['quantity'],
                            'unit_price' => $item['unit_price'],
                            'total_price' => $item['total_price'],
                            'store_id' => $item['store_id'],
                        ]);
                    } else {
                        // Create new item
                        QuoteItem::create([
                            'quote_id' => $quote->id,
                            'item_type' => $item['type'],
                            'product_id' => $item['type'] === 'product' ? $item['product_id'] : null,
                            'name' => $item['name'],
                            'quantity' => $item['quantity'],
                            'unit_price' => $item['unit_price'],
                            'total_price' => $item['total_price'],
                            'store_id' => $item['store_id'],
                            'status' => 'pending',
                        ]);
                    }
                }

                $this->emit('alert', 'success', 'Quote updated successfully!');
            } else {
                // Create new quote
                $quote = Quote::create([
                    'client_id' => $this->clientId,
                    'mechanic_id' => Auth::id(),
                    'title' => $this->title,
                    'description' => $this->description,
                    'status' => 'draft',
                    'total_amount' => $totalAmount,
                    'valid_until' => $this->validUntil,
                ]);

                // Create items
                foreach ($this->items as $item) {
                    QuoteItem::create([
                        'quote_id' => $quote->id,
                        'item_type' => $item['type'],
                        'product_id' => $item['type'] === 'product' ? $item['product_id'] : null,
                        'name' => $item['name'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'total_price' => $item['total_price'],
                        'store_id' => $item['store_id'],
                        'status' => 'pending',
                    ]);
                }

                $this->emit('alert', 'success', 'Quote created successfully!');
            }

            DB::commit();

            $this->isCreating = false;
            $this->isEditing = false;

        } catch (\Exception $e) {
            DB::rollBack();
            $this->emit('alert', 'error', 'Error: ' . $e->getMessage());
        }
    }

    public function submitForApproval()
    {
        if (!$this->quoteId) {
            $this->emit('alert', 'error', 'Please save the quote first.');
            return;
        }

        $quote = Quote::findOrFail($this->quoteId);

        // Check if all items have stores assigned
        $missingStores = collect($this->items)->filter(function ($item) {
            return $item['type'] === 'product' && empty($item['store_id']);
        })->count();

        if ($missingStores > 0) {
            $this->emit('alert', 'error', 'All product items must have a store assigned before submitting.');
            return;
        }

        // Update quote status
        $quote->update(['status' => 'pending_store']);

        // Notify stores
        $storeIds = collect($this->items)
            ->where('type', 'product')
            ->pluck('store_id')
            ->unique()
            ->toArray();

        foreach ($storeIds as $storeId) {
            Notification::create([
                'user_id' => $storeId,
                'type' => 'quote_pending',
                'message' => "New quote #{$quote->id} requires your approval",
                'notifiable_type' => 'App\Models\Quote',
                'notifiable_id' => $quote->id,
            ]);
        }

        $this->emit('alert', 'success', 'Quote submitted for store approval!');
        $this->isEditing = false;
    }

    // Item Management Functions
    public function addItem()
    {
        $this->resetValidation();
        $this->resetItemForm();
        $this->showItemForm = true;
        $this->editingItemIndex = null;

        // Load available stores for products
        $this->stores = User::where('role', 'store')->get();

        // Load available services if user is mechanic
        if (Auth::user()->role === 'mechanic') {
            $this->availableServices = Service::where('mechanic_id', Auth::id())->get();
        }
    }

    public function editItem($index)
    {
        $this->resetValidation();
        $this->resetItemForm();

        $item = $this->items[$index];
        $this->itemType = $item['type'];
        $this->productId = $item['type'] === 'product' ? $item['product_id'] : null;
        $this->serviceId = $item['type'] === 'service' ? $item['product_id'] : null;
        $this->itemName = $item['name'];
        $this->itemQuantity = $item['quantity'];
        $this->itemPrice = $item['unit_price'];
        $this->storeId = $item['store_id'];

        // Load available stores
        $this->stores = User::where('role', 'store')->get();

        // Load available services if user is mechanic
        if (Auth::user()->role === 'mechanic') {
            $this->availableServices = Service::where('mechanic_id', Auth::id())->get();
        }

        // Set editing index
        $this->showItemForm = true;
        $this->editingItemIndex = $index;
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function saveItem()
    {
        // Validate item data
        $this->validate([
            'itemType' => 'required|in:product,service',
            'itemName' => 'required|string|max:255',
            'itemQuantity' => 'required|integer|min:1',
            'itemPrice' => 'required|numeric|min:0',
            'storeId' => $this->itemType === 'product' ? 'required' : 'nullable',
        ]);

        // Calculate total price
        $totalPrice = $this->itemQuantity * $this->itemPrice;

        // Get store name
        $storeName = null;
        if ($this->storeId) {
            $store = User::find($this->storeId);
            $storeName = $store ? $store->name : null;
        }

        // Prepare item data
        $item = [
            'type' => $this->itemType,
            'product_id' => $this->productId,
            'name' => $this->itemName,
            'quantity' => $this->itemQuantity,
            'unit_price' => $this->itemPrice,
            'total_price' => $totalPrice,
            'store_id' => $this->storeId,
            'store_name' => $storeName,
            'status' => 'pending'
        ];

        if ($this->editingItemIndex !== null) {
            // Update existing item
            $this->items[$this->editingItemIndex] = $item;
        } else {
            // Add new item
            $this->items[] = $item;
        }

        $this->showItemForm = false;
        $this->resetItemForm();
    }

    public function setSelectedProduct($product)
    {
        $this->productId = $product['id'];
        $this->itemName = $product['name'];
        $this->itemPrice = $product['price'];
    }

    public function setSelectedService($service)
    {
        $this->serviceId = $service['id'];
        $this->itemName = $service['name'];
        $this->itemPrice = $service['price'];
    }

    public function cancelItemForm()
    {
        $this->showItemForm = false;
        $this->resetItemForm();
    }

    // Communication Functions
    public function openMessageModal($recipientId, $recipientName)
    {
        $this->messageRecipientId = $recipientId;
        $this->messageRecipientName = $recipientName;
        $this->messageContent = '';
        $this->showMessageModal = true;
    }

    public function sendMessage()
    {
        $this->validate([
            'messageContent' => 'required|string',
            'messageRecipientId' => 'required|exists:users,id',
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'recipient_id' => $this->messageRecipientId,
            'quote_id' => $this->quoteId,
            'content' => $this->messageContent,
        ]);

        // Create notification
        Notification::create([
            'user_id' => $this->messageRecipientId,
            'type' => 'new_message',
            'message' => Auth::user()->name . ' sent you a message',
            'notifiable_type' => 'App\Models\Message',
            'notifiable_id' => DB::getPdo()->lastInsertId(),
        ]);

        $this->emit('alert', 'success', 'Message sent successfully!');
        $this->showMessageModal = false;
    }

    // Approval Functions
    public function approveItem($itemId)
    {
        $item = QuoteItem::findOrFail($itemId);
        $item->update(['status' => 'approved']);

        $this->checkQuoteStatus($item->quote_id);
        $this->emit('alert', 'success', 'Item approved!');
    }

    public function rejectItem($itemId)
    {
        $item = QuoteItem::findOrFail($itemId);
        $item->update(['status' => 'rejected']);

        $this->emit('alert', 'success', 'Item rejected!');
    }

    public function approveQuote($quoteId)
    {
        $quote = Quote::findOrFail($quoteId);

        if (Auth::user()->role === 'client' && $quote->status === 'pending_client') {
            $quote->update(['status' => 'approved']);

            // Notify mechanic
            Notification::create([
                'user_id' => $quote->mechanic_id,
                'type' => 'quote_approved',
                'message' => "Quote #{$quote->id} has been approved by the client",
                'notifiable_type' => 'App\Models\Quote',
                'notifiable_id' => $quote->id,
            ]);

            $this->emit('alert', 'success', 'Quote approved!');
        }
    }

    public function rejectQuote($quoteId)
    {
        $quote = Quote::findOrFail($quoteId);

        if ((Auth::user()->role === 'client' && $quote->client_id === Auth::id()) ||
            (Auth::user()->role === 'store' && $quote->items()->where('store_id', Auth::id())->exists())) {

            $quote->update(['status' => 'rejected']);

            // Notify mechanic
            Notification::create([
                'user_id' => $quote->mechanic_id,
                'type' => 'quote_rejected',
                'message' => "Quote #{$quote->id} has been rejected by " . Auth::user()->name,
                'notifiable_type' => 'App\Models\Quote',
                'notifiable_id' => $quote->id,
            ]);

            $this->emit('alert', 'success', 'Quote rejected!');
        }
    }

    // Helper Functions
    private function checkQuoteStatus($quoteId)
    {
        $quote = Quote::findOrFail($quoteId);

        // If all store items are approved, change status to pending_client
        if ($quote->status === 'pending_store') {
            $pendingItems = $quote->items()->where('status', 'pending')->count();
            $rejectedItems = $quote->items()->where('status', 'rejected')->count();

            if ($pendingItems === 0 && $rejectedItems === 0) {
                $quote->update(['status' => 'pending_client']);

                // Notify client
                Notification::create([
                    'user_id' => $quote->client_id,
                    'type' => 'quote_ready',
                    'message' => "Quote #{$quote->id} is ready for your approval",
                    'notifiable_type' => 'App\Models\Quote',
                    'notifiable_id' => $quote->id,
                ]);
            }
        }
    }

    private function resetForm()
    {
        $this->quoteId = null;
        $this->clientId = null;
        $this->title = '';
        $this->description = '';
        $this->validUntil = '';
        $this->items = [];
    }

    private function resetItemForm()
    {
        $this->itemType = 'product';
        $this->productId = null;
        $this->serviceId = null;
        $this->itemName = '';
        $this->itemQuantity = 1;
        $this->itemPrice = '';
        $this->storeId = null;
        $this->searchProduct = '';
        $this->searchService = '';
        $this->availableProducts = [];
    }

    // Search Functions for Products
    public function updatedSearchProduct()
    {
        if (strlen($this->searchProduct) >= 2) {
            $this->availableProducts = Product::where('name', 'like', '%' . $this->searchProduct . '%')
                ->when($this->storeId, function ($query) {
                    return $query->where('store_id', $this->storeId);
                })
                ->take(5)
                ->get();
        } else {
            $this->availableProducts = [];
        }
    }

    public function render()
    {
        $user = Auth::user();

        $quotesQuery = Quote::query();

        // Apply role-based filters
        if ($user->role === 'mechanic') {
            $quotesQuery->where('mechanic_id', $user->id);
        } elseif ($user->role === 'client') {
            $quotesQuery->where('client_id', $user->id);
        } elseif ($user->role === 'store') {
            $quotesQuery->whereHas('items', function ($query) use ($user) {
                $query->where('store_id', $user->id);
            });
        }

        // Apply search
        if (!empty($this->search)) {
            $quotesQuery->where(function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('id', 'like', '%' . $this->search . '%');
            });
        }

        // Apply status filter
        if ($this->statusFilter !== 'all') {
            $quotesQuery->where('status', $this->statusFilter);
        }

        // Apply date filter
        if (!empty($this->dateFilter)) {
            $quotesQuery->whereDate('created_at', $this->dateFilter);
        }

        // Get quotes with relations
        $quotes = $quotesQuery->with(['client', 'mechanic', 'items'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.mechanical.quote-management', [
            'quotes' => $quotes,
        ])->layout('layouts.app');
    }
}
