<?php

namespace App\Livewire\Frontend\Home;

use App\Models\Product;
use Livewire\Component;

class SpecialProducts extends Component
{
    public function render()
    {
        // Fetch active, featured products.
        // We eager load 'reviews' count and avg rating for the UI.
        $products = Product::active()
            ->featured()
            ->withAvg('reviews', 'rating') // Calculates 'reviews_avg_rating'
            ->latest()
            ->take(8) // Limit to 8 items to match the layout
            ->get();

        return view('livewire.frontend.home.special-products', [
            'products' => $products
        ]);
    }
}
