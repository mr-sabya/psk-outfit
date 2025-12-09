<?php

namespace App\Livewire\Frontend\Home;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class NewArrivalProducts extends Component
{
    public Collection $products;

    public function mount()
    {
        // Fetch active products marked as 'is_new', sorted by creation date
        $this->products = Product::active()
            ->where('is_new', true)
            ->with(['reviews', 'variants.attributeValues']) // Eager load relationships
            ->latest() // Order by created_at desc
            ->take(10) // Limit to 10 items
            ->get();

        // Fallback: If no products are manually marked as 'New', 
        // just take the 10 most recently added active products.
        if ($this->products->isEmpty()) {
            $this->products = Product::active()
                ->with(['reviews', 'variants.attributeValues'])
                ->latest()
                ->take(10)
                ->get();
        }
    }

    public function render()
    {
        return view('livewire.frontend.home.new-arrival-products');
    }
}
