<?php

namespace App\Livewire\Frontend\Home;

use Livewire\Component;
use App\Models\Category as CategoryModel; // Alias to avoid class name conflict

class Category extends Component
{
    public function render()
    {
        // Fetch active parent categories (where parent_id is NULL)
        $categories = CategoryModel::query()
            ->active() // Scoped from your model
            ->parentCategories() // Scoped from your model (whereNull('parent_id'))
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('livewire.frontend.home.category', [
            'categories' => $categories
        ]);
    }
}
