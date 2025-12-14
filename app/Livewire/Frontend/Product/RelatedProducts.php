<?php

namespace App\Livewire\Frontend\Product;

use App\Models\Product;
use Livewire\Component;

class RelatedProducts extends Component
{
    public $relatedProducts = [];

    public function mount($productId)
    {
        // 1. Find the main product to get its categories
        // We assume the ID passed is valid, but use find() to be safe
        $mainProduct = Product::with('categories')->find($productId);

        if ($mainProduct) {
            $categoryIds = $mainProduct->categories->pluck('id');

            // 2. Fetch products in the same categories, excluding the current one
            $this->relatedProducts = Product::active()
                ->where('id', '!=', $productId) // Exclude the current product
                ->whereHas('categories', function ($query) use ($categoryIds) {
                    $query->whereIn('categories.id', $categoryIds);
                })
                ->withAvg('reviews', 'rating') // Eager load rating for the card
                ->latest()
                ->take(10) // Limit to 10 items for the slider
                ->get();
        }
    }

    public function render()
    {
        return view('livewire.frontend.product.related-products');
    }
}
