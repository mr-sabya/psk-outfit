<?php

namespace App\Livewire\Frontend\Theme;

use App\Models\Category;
use Livewire\Component;

class Search extends Component
{
    public function render()
    {
        return view('livewire.frontend.theme.search', [
            'categories' => Category::query()
                ->active() // Scoped from your model
                ->parentCategories() // Scoped from your model (whereNull('parent_id'))
                ->orderBy('sort_order', 'asc')
                ->get(),
        ]);
    }
}
