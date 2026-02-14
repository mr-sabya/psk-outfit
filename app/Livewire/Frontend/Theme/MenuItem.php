<?php

namespace App\Livewire\Frontend\Theme;

use App\Models\Category;
use Livewire\Component;

class MenuItem extends Component
{
    public $className = 'menu_item';
    public $categories;

    public function mount($className = 'menu_item')
    {
        $this->className = $className;

        // Fetch parent categories (where parent_id is null) 
        // with their active children
        $this->categories = Category::active()
            ->where('slug', '!=', 'lustrai-wear')
            ->parentCategories()
            ->with(['children' => function ($query) {
                $query->active()->orderBy('sort_order', 'asc');
            }])
            ->orderBy('sort_order', 'asc')
            ->get();
    }

    public function render()
    {
        return view('livewire.frontend.theme.menu-item');
    }
}
