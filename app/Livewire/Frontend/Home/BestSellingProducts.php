<?php

namespace App\Livewire\Frontend\Home;

use App\Models\Product;
use Livewire\Component;

class BestSellingProducts extends Component
{
    public function render()
    {
        // Fetch 4 active products.
        // Note: To make this truly "Best Selling", you would typically join with
        // an 'order_items' table and count sales. For now, we fetch the latest/featured.
        $products = Product::active()
            ->whereDoesntHave('categories', function ($query) {
                $query->where('slug', 'lustra-wear');
            })
            ->latest()
            ->take(4)
            ->get();

        return view('livewire.frontend.home.best-selling-products', [
            // Split the collection: First 3 for the grid, the 4th for the large banner
            'gridProducts' => $products->take(3),
            'featuredProduct' => $products->skip(3)->first()
        ]);
    }
}
