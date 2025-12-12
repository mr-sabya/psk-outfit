<?php

namespace App\Livewire\Frontend\Shop;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;
use App\Models\AttributeValue;
use Illuminate\Database\Eloquent\Builder;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Sidebar Data
    public $categories;
    public $colors;
    public $sizes; // <--- ADD THIS
    public $topRatedProducts;

    // Filters
    public $minPrice = 0;
    public $maxPrice = 1000;
    public $selectedCategory = null;
    public $selectedColors = [];
    public $selectedSizes = []; // <--- ADD THIS
    public $selectedRating = null;
    public $isOnSale = false;
    public $isInStock = false;

    // Sorting & Display
    public $sortBy = 'default';
    public $perPage = 12;

    protected $queryString = [
        'minPrice' => ['except' => 0],
        'maxPrice' => ['except' => 1000],
        'selectedCategory' => ['except' => null],
        'selectedColors' => ['except' => []],
        'selectedSizes' => ['except' => []], // <--- ADD THIS
        'isOnSale' => ['except' => false],
        'sortBy' => ['except' => 'default'],
    ];

    public function mount()
    {
        // 1. Categories
        $this->categories = Category::active()
            ->withCount(['products' => function (Builder $query) {
                $query->active();
            }])
            ->get();

        // 2. GET COLORS: Where Attribute slug is 'color' AND has variants
        $this->colors = AttributeValue::whereHas('attribute', function ($query) {
            $query->where('slug', 'color')
                ->orWhere('name', 'Color'); // Fallback for safety
        })
            ->whereHas('productVariants') // Only show colors attached to products
            ->get();

        // 3. GET SIZES: Where Attribute slug is 'size' AND has variants
        $this->sizes = AttributeValue::whereHas('attribute', function ($query) {
            $query->where('slug', 'size')
                ->orWhere('name', 'Size');
        })
            ->whereHas('productVariants')
            ->get();

        // 4. Top Rated
        $this->topRatedProducts = Product::active()
            ->withAvg('reviews', 'rating')
            ->orderByDesc('reviews_avg_rating')
            ->take(4)
            ->get();

        if (request()->has('category')) {
            $this->selectedCategory = request('category');
        }
    }

    public function updated($propertyName)
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        // Reset all filter properties to their default values
        $this->reset([
            'selectedCategory',
            'selectedColors',
            'selectedSizes',
            'selectedRating',
            'isOnSale',
            'isInStock',
            'sortBy'
        ]);

        // Manually reset price to default range
        $this->minPrice = 0;
        $this->maxPrice = 1000;

        // Reset pagination to page 1
        $this->resetPage();

        // Dispatch event to JavaScript to reset the UI Slider visually
        $this->dispatch('reset-price-slider', min: 0, max: 1000);
    }

    public function render()
    {
        $products = Product::active()
            ->with(['reviews', 'variants.attributeValues']);

        // ... Price Filter ...
        $products->whereBetween('price', [$this->minPrice, $this->maxPrice]);

        // ... Category Filter ...
        if ($this->selectedCategory) {
            $products->whereHas('categories', function ($query) {
                $query->where('slug', $this->selectedCategory)
                    ->orWhere('id', $this->selectedCategory);
            });
        }

        // ... Color Filter ...
        if (!empty($this->selectedColors)) {
            $products->whereHas('variants.attributeValues', function ($query) {
                $query->whereIn('attribute_values.id', $this->selectedColors);
            });
        }

        // ... Size Filter (ADD THIS) ...
        if (!empty($this->selectedSizes)) {
            $products->whereHas('variants.attributeValues', function ($query) {
                $query->whereIn('attribute_values.id', $this->selectedSizes);
            });
        }

        // ... Rating, Status, Sorting ...
        if ($this->selectedRating) {
            $products->whereHas('reviews', function ($query) {
                $query->selectRaw('avg(rating) as avg_rating')
                    ->groupBy('product_id')
                    ->havingRaw('avg_rating >= ?', [$this->selectedRating]);
            });
        }

        if ($this->isOnSale) {
            $products->whereColumn('compare_at_price', '>', 'price');
        }

        if ($this->isInStock) {
            $products->where(function ($query) {
                $query->where('is_manage_stock', false)
                    ->orWhere('quantity', '>', 0);
            });
        }

        switch ($this->sortBy) {
            case 'low_high':
                $products->orderBy('price', 'asc');
                break;
            case 'high_low':
                $products->orderBy('price', 'desc');
                break;
            case 'new':
                $products->orderBy('created_at', 'desc');
                break;
            case 'sale':
                $products->orderByRaw('(compare_at_price - price) DESC');
                break;
            default:
                $products->orderBy('created_at', 'desc');
                break;
        }

        return view('livewire.frontend.shop.index', [
            'products' => $products->paginate($this->perPage)
        ]);
    }
}
