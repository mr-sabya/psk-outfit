<?php

namespace App\Livewire\Frontend\Home;

use Livewire\Component;
use App\Models\Category;

class TrendingProducts extends Component
{
    public $tabs = [];

    public function mount()
    {
        // 1. Get Categories
        // We use the scopeFeaturedOnHomepage() you defined in your Category model
        // If no categories are marked for homepage, we fallback to just active categories
        $categories = Category::featuredOnHomepage()
            ->where('slug', '!=', 'lustra-wear')
            ->orderBy('sort_order', 'asc')
            ->take(5)
            ->get();

        // Fallback if no homepage categories exist
        if ($categories->isEmpty()) {
            $categories = Category::active()
                ->orderBy('id', 'desc')
                ->take(4)
                ->get();
        }

        // 2. Prepare Data Structure
        foreach ($categories as $category) {
            $this->tabs[] = [
                'id' => 'tab_' . $category->id, // Unique ID for the JS tab plugin
                'name' => $category->name,      // Display name

                // 3. Get Products for this Category
                // utilizing the relationship and scopes
                'products' => $category->products()
                    ->active()       // Scope from Product model
                    ->with(['reviews', 'variants']) // Eager load for performance
                    ->latest()
                    ->take(10)       // Limit products per tab
                    ->get()
            ];
        }
    }

    public function render()
    {
        return view('livewire.frontend.home.trending-products');
    }
}
