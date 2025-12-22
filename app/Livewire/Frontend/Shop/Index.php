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
    public $sizes;
    public $topRatedProducts;

    // Filters
    public $search = ''; // Added search property
    public $minPrice = 0;
    public $maxPrice = 1000;

    // Limits for the slider UI (to know the absolute bounds)
    public $priceRangeMin = 0;
    public $priceRangeMax = 1000;

    public $selectedCategory = null;
    public $selectedColors = [];
    public $selectedSizes = [];
    public $selectedRating = null;
    public $isOnSale = false;
    public $isInStock = false;

    // Sorting & Display
    public $sortBy = 'default';
    public $perPage = 12;

    protected $queryString = [
        'search' => ['except' => ''], // Added to query string
        'minPrice' => ['except' => 0],
        'maxPrice' => ['except' => 1000],
        'selectedCategory' => ['except' => null],
        'selectedColors' => ['except' => []],
        'selectedSizes' => ['except' => []],
        'isOnSale' => ['except' => false],
        'sortBy' => ['except' => 'default'],
    ];

    public function mount()
    {
        // 1. DYNAMIC PRICE: Get actual min/max from DB to ensure products aren't hidden
        $this->priceRangeMin = floor(Product::min('price') ?? 0);
        $this->priceRangeMax = ceil(Product::max('price') ?? 1000);

        // If URL doesn't have custom price, use DB limits
        if (!request()->has('minPrice')) {
            $this->minPrice = $this->priceRangeMin;
        }
        if (!request()->has('maxPrice')) {
            $this->maxPrice = $this->priceRangeMax;
        }

        // 2. Categories
        $this->categories = Category::active()
            ->withCount(['products' => function (Builder $query) {
                $query->active();
            }])
            ->get();

        // 3. Colors
        $this->colors = AttributeValue::whereHas('attribute', function ($query) {
            $query->where('slug', 'color')->orWhere('name', 'Color');
        })->get();

        // 4. Sizes
        $this->sizes = AttributeValue::whereHas('attribute', function ($query) {
            $query->where('slug', 'size')->orWhere('name', 'Size');
        })->get();

        // 5. Top Rated
        $this->topRatedProducts = Product::active()
            ->withAvg('reviews', 'rating')
            ->orderByDesc('reviews_avg_rating')
            ->take(3)
            ->get();

        if (request()->has('category')) {
            $this->selectedCategory = request('category');
        }

        // Handle search from request (e.g. from header search bar)
        if (request()->has('search')) {
            $this->search = request('search');
        }
    }

    public function updated($propertyName)
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset([
            'search', // Added to reset
            'selectedCategory',
            'selectedColors',
            'selectedSizes',
            'selectedRating',
            'isOnSale',
            'isInStock',
            'sortBy'
        ]);

        // Reset price to the DB limits calculated in mount
        $this->minPrice = $this->priceRangeMin;
        $this->maxPrice = $this->priceRangeMax;

        $this->resetPage();

        // Dispatch event for UI Slider (if you are using one)
        $this->dispatch('reset-price-slider', min: $this->minPrice, max: $this->maxPrice);
    }

    public function render()
    {
        $products = Product::active()
            // Eager load necessary relationships
            ->with(['reviews', 'variants', 'categories']);

        // --- New Search Filter ---
        if ($this->search) {
            $products->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('long_description', 'like', '%' . $this->search . '%')
                    ->orWhere('short_description', 'like', '%' . $this->search . '%');
            });
        }

        // --- 1. Price Filter ---
        // Use whereBetween on the price column
        $products->whereBetween('price', [$this->minPrice, $this->maxPrice]);

        // --- 2. Category Filter ---
        if ($this->selectedCategory) {
            $products->whereHas('categories', function ($query) {
                $query->where('categories.slug', $this->selectedCategory)
                    ->orWhere('categories.id', $this->selectedCategory);
            });
        }

        // --- 3. Color Filter ---
        if (!empty($this->selectedColors)) {
            $products->where(function ($query) {
                // Check Simple Product attributes
                $query->whereHas('attributeValues', function ($q) {
                    $q->whereIn('attribute_values.id', $this->selectedColors);
                })
                    // OR Check Variable Product attributes
                    ->orWhereHas('variants.attributeValues', function ($q) {
                        $q->whereIn('attribute_values.id', $this->selectedColors);
                    });
            });
        }

        // --- 4. Size Filter ---
        if (!empty($this->selectedSizes)) {
            $products->where(function ($query) {
                // Check Simple Product attributes
                $query->whereHas('attributeValues', function ($q) {
                    $q->whereIn('attribute_values.id', $this->selectedSizes);
                })
                    // OR Check Variable Product attributes
                    ->orWhereHas('variants.attributeValues', function ($q) {
                        $q->whereIn('attribute_values.id', $this->selectedSizes);
                    });
            });
        }

        // --- 5. Rating Filter ---
        if ($this->selectedRating) {
            // Filter by calculating average rating
            $products->withAvg('reviews', 'rating')
                ->having('reviews_avg_rating', '>=', $this->selectedRating);
        }

        // --- 6. On Sale Filter ---
        if ($this->isOnSale) {
            $products->whereNotNull('compare_at_price')
                ->whereColumn('compare_at_price', '>', 'price');
        }

        // --- 7. In Stock Filter ---
        if ($this->isInStock) {
            $products->where(function ($query) {
                // Case A: Stock management disabled (always in stock)
                $query->where('is_manage_stock', false)
                    // Case B: Simple Product with quantity > 0
                    ->orWhere(function ($q) {
                        $q->where('is_manage_stock', true)
                            ->where('quantity', '>', 0);
                    })
                    // Case C: Variable Product (check sum of variants)
                    ->orWhereHas('variants', function ($q) {
                        $q->where('quantity', '>', 0);
                    });
            });
        }

        // --- 8. Sorting ---
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
