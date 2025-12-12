<?php

namespace App\Livewire\Frontend\Components;

use Livewire\Component;
use App\Models\Category as CategoryModel; // Alias to avoid conflict with Class name

class Category extends Component
{
    public CategoryModel $category;

    /**
     * Mount the component.
     * @param int|CategoryModel $category
     */
    public function mount($category)
    {
        // If an integer ID is passed, fetch the model. 
        // If the Model is passed directly (e.g. in a loop), use it to save queries.
        $this->category = $category instanceof CategoryModel
            ? $category
            : CategoryModel::findOrFail($category);
    }

    public function render()
    {
        return view('livewire.frontend.components.category');
    }
}
