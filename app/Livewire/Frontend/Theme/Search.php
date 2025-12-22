<?php

namespace App\Livewire\Frontend\Theme;

use App\Models\Category;
use Livewire\Component;

class Search extends Component
{
    public $search = '';
    public $category = '';

    public function handleSearch()
    {
        // Redirect to the shop page with the search and category as query parameters
        return $this->redirect(route('shop', [
            'search' => $this->search,
            'category' => $this->category
        ]), navigate: true);
    }

    public function render()
    {
        return view('livewire.frontend.theme.search', [
            'categories' => Category::query()
                ->active()
                ->parentCategories()
                ->orderBy('name', 'asc') // Usually alphabetical is better for search
                ->get(),
        ]);
    }
}
