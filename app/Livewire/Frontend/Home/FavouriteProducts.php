<?php

namespace App\Livewire\Frontend\Home;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class FavouriteProducts extends Component
{
    public Collection $products;

    public function mount()
    {
        // Fetch products marked as 'is_featured'
        $this->products = Product::active()
            ->featured() // Uses the scopeFeatured() from your Product model
            ->with(['reviews', 'variants.attributeValues']) // Eager load
            ->latest()
            ->take(8) // Limit for the slider
            ->get();

        // Fallback: If no featured products exist, show latest active products
        if ($this->products->isEmpty()) {
            $this->products = Product::active()
                ->with(['reviews', 'variants.attributeValues'])
                ->latest()
                ->take(8)
                ->get();
        }
    }

    public function render()
    {
        return view('livewire.frontend.home.favourite-products');
    }
}
