<?php

namespace App\Livewire\Mechanical;

use App\Models\PriceHistory;
use App\Models\Product;
use App\Models\ProductBatch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class InventoryManagement extends Component
{
    use WithPagination;

    // Product List Properties
    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $filter = 'all';

    // Selected Product Properties
    public $selectedProduct = null;
    public $isEditing = false;
    public $showBatchModal = false;
    public $showPriceHistoryModal = false;

    // Form Properties
    public $productId;
    public $name;
    public $sku;
    public $description;
    public $price;
    public $stockQuantity;
    public $minStockLevel;
    public $notifyLowStock;
    public $category;

    // Batch Form Properties
    public $batchNumber;
    public $batchQuantity;
    public $expiryDate;
    public $purchasePrice;
    public $sellingPrice;

    // Listeners
    protected $listeners = ['refreshProducts' => '$refresh'];

    // Reset pagination when filters change
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    // Sorting
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    // Create/Edit Product
    public function createProduct()
    {
        $this->resetValidation();
        $this->resetForm();
        $this->isEditing = true;
    }

    public function editProduct(Product $product)
    {
        $this->resetValidation();
        $this->productId = $product->id;
        $this->name = $product->name;
        $this->sku = $product->sku;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->stockQuantity = $product->stock_quantity;
        $this->minStockLevel = $product->min_stock_level;
        $this->notifyLowStock = $product->notify_low_stock;
        $this->category = $product->category;

        $this->isEditing = true;
    }

    public function saveProduct()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'sku' => ['nullable', 'string', 'max:50', Rule::unique('products', 'sku')->ignore($this->productId)],
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stockQuantity' => 'required|integer|min:0',
            'minStockLevel' => 'required|integer|min:0',
            'category' => 'nullable|string|max:100',
        ]);

        if ($this->productId) {
            // Update existing product
            $product = Product::findOrFail($this->productId);
            $oldPrice = $product->price;

            $product->update([
                'name' => $this->name,
                'sku' => $this->sku,
                'description' => $this->description,
                'price' => $this->price,
                'stock_quantity' => $this->stockQuantity,
                'min_stock_level' => $this->minStockLevel,
                'notify_low_stock' => $this->notifyLowStock,
                'category' => $this->category,
            ]);

            // Record price history if price changed
            if ($oldPrice != $this->price) {
                PriceHistory::create([
                    'product_id' => $product->id,
                    'old_price' => $oldPrice,
                    'new_price' => $this->price,
                    'reason' => 'Price update',
                    'updated_by' => Auth::id(),
                ]);
            }

            $this->emit('alert', 'success', 'Product updated successfully!');
        } else {
            // Create new product
            $product = Product::create([
                'store_id' => Auth::id(),
                'name' => $this->name,
                'sku' => $this->sku,
                'description' => $this->description,
                'price' => $this->price,
                'stock_quantity' => $this->stockQuantity,
                'min_stock_level' => $this->minStockLevel,
                'notify_low_stock' => $this->notifyLowStock,
                'category' => $this->category,
            ]);

            $this->emit('alert', 'success', 'Product added successfully!');
        }

        $this->resetForm();
        $this->isEditing = false;
    }

    public function cancelEdit()
    {
        $this->resetForm();
        $this->isEditing = false;
    }

    // Batch Management
    public function openBatchModal(Product $product)
    {
        $this->selectedProduct = $product;
        $this->resetBatchForm();
        $this->sellingPrice = $product->price;
        $this->showBatchModal = true;
    }

    public function saveBatch()
    {
        $this->validate([
            'batchNumber' => 'required|string|max:50',
            'batchQuantity' => 'required|integer|min:1',
            'expiryDate' => 'nullable|date|after:today',
            'purchasePrice' => 'nullable|numeric|min:0',
            'sellingPrice' => 'required|numeric|min:0',
        ]);

        // Create batch
        ProductBatch::create([
            'product_id' => $this->selectedProduct->id,
            'batch_number' => $this->batchNumber,
            'quantity' => $this->batchQuantity,
            'expiry_date' => $this->expiryDate,
            'purchase_price' => $this->purchasePrice,
            'selling_price' => $this->sellingPrice,
        ]);

        // Update product stock quantity
        $this->selectedProduct->increment('stock_quantity', $this->batchQuantity);

        // Record price history if selling price is different
        if ($this->selectedProduct->price != $this->sellingPrice) {
            PriceHistory::create([
                'product_id' => $this->selectedProduct->id,
                'old_price' => $this->selectedProduct->price,
                'new_price' => $this->sellingPrice,
                'reason' => 'New batch with different price',
                'updated_by' => Auth::id(),
            ]);

            // Update product price to new selling price
            $this->selectedProduct->update(['price' => $this->sellingPrice]);
        }

        $this->emit('alert', 'success', 'Batch added successfully!');
        $this->closeBatchModal();
    }

    public function closeBatchModal()
    {
        $this->showBatchModal = false;
        $this->resetBatchForm();
    }

    // Price History
    public function viewPriceHistory(Product $product)
    {
        $this->selectedProduct = $product;
        $this->showPriceHistoryModal = true;
    }

    public function closePriceHistoryModal()
    {
        $this->showPriceHistoryModal = false;
    }

    // Reset Forms
    private function resetForm()
    {
        $this->productId = null;
        $this->name = '';
        $this->sku = '';
        $this->description = '';
        $this->price = '';
        $this->stockQuantity = 0;
        $this->minStockLevel = 5;
        $this->notifyLowStock = true;
        $this->category = '';
    }

    private function resetBatchForm()
    {
        $this->batchNumber = '';
        $this->batchQuantity = '';
        $this->expiryDate = '';
        $this->purchasePrice = '';
        $this->sellingPrice = '';
    }

    // Check for low stock
    private function getProducts()
    {
        $query = Product::query()
            ->where('store_id', Auth::id());

        // Apply search
        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('sku', 'like', '%' . $this->search . '%')
                    ->orWhere('category', 'like', '%' . $this->search . '%');
            });
        }

        // Apply filters
        switch ($this->filter) {
            case 'low-stock':
                $query->whereRaw('stock_quantity <= min_stock_level');
                break;
            case 'out-of-stock':
                $query->where('stock_quantity', 0);
                break;
        }

        // Apply sorting
        return $query->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);
    }

    // Delete product
    public function confirmDelete($productId)
    {
        $this->emit('confirmDelete', $productId);
    }

    public function deleteProduct($productId)
    {
        $product = Product::findOrFail($productId);
        $product->delete();

        $this->emit('alert', 'success', 'Product deleted successfully!');
    }

    public function render()
    {
        $products = $this->getProducts();

        // Get batches for selected product
        $batches = collect();
        $priceHistory = collect();

        if ($this->selectedProduct) {
            $batches = ProductBatch::where('product_id', $this->selectedProduct->id)
                ->orderBy('created_at', 'desc')
                ->get();

            $priceHistory = PriceHistory::where('product_id', $this->selectedProduct->id)
                ->with('updatedBy')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('livewire.mechanical.inventory-management', [
            'products' => $products,
            'batches' => $batches,
            'priceHistory' => $priceHistory,
        ])->layout('layouts.app');
    }
}
