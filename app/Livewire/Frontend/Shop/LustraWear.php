<?php

namespace App\Livewire\Frontend\Shop;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;

class LustraWear extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $category;
    public $sortBy = 'new';
    public $perPage = 12;

    public function mount()
    {
        // Fetch the specific category
        $this->category = Category::where('slug', 'lustra-wear')->active()->firstOrFail();
    }

    public function render()
    {
        $products = Product::active()
            ->whereHas('categories', function ($query) {
                $query->where('slug', 'lustra-wear');
            })
            ->with(['reviews', 'variants']);

        // Basic Sorting logic
        switch ($this->sortBy) {
            case 'low_high':
                $products->orderBy('price', 'asc');
                break;
            case 'high_low':
                $products->orderBy('price', 'desc');
                break;
            default:
                $products->orderBy('created_at', 'desc');
                break;
        }

        return view('livewire.frontend.shop.lustra-wear', [
            'products' => $products->paginate($this->perPage)
        ]);
    }
}
