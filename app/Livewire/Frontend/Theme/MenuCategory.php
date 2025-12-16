<?php

namespace App\Livewire\Frontend\Theme;

use App\Models\Category;
use Livewire\Component;

class MenuCategory extends Component
{
    public function render()
    {
        // Fetch Parent categories with their active children and grandchildren
        $categories = Category::parentCategories()
            ->active()
            ->orderBy('sort_order', 'asc')
            ->with(['children' => function ($query) {
                $query->active()
                    ->orderBy('sort_order', 'asc')
                    ->with(['children' => function ($subQuery) {
                        $subQuery->active()->orderBy('sort_order', 'asc');
                    }]);
            }])
            // Optional: Limit to 10-12 items to prevent breaking UI height
            // ->take(10) 
            ->get();

        return view('livewire.frontend.theme.menu-category', [
            'categories' => $categories
        ]);
    }
}
