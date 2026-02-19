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
            ->whereDoesntHave('categories', function ($query) {
                $query->where('slug', 'lustra-wear');
            })
            ->withAvg('reviews', 'rating')
            ->latest()
            ->take(8)
            ->get();

        return view('livewire.frontend.home.special-products', [
            'products' => $products
        ]);
    }
}
