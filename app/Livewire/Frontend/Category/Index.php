<?php

namespace App\Livewire\Frontend\Category;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;
use Livewire\WithoutUrlPagination;

class Index extends Component
{
    use WithPagination, WithoutUrlPagination;

    public function render()
    {
        // Fetch active categories, sorted by your preference (e.g., sort_order or name)
        $categories = Category::active()
            ->orderBy('sort_order', 'asc') // Change to 'name' if you prefer alphabetical
            ->paginate(12); // Adjust the number of items per page here

        return view('livewire.frontend.category.index', [
            'categories' => $categories
        ]);
    }
}