<?php

namespace App\Livewire\Frontend\Compare;

use App\Livewire\Frontend\Traits\CartTrait;
use Livewire\Component;
use App\Models\Product; // Ensure you have a Product model
use Illuminate\Support\Facades\Session;

class Index extends Component
{
    use CartTrait;
    public $products = [];

    public function mount()
    {
        $this->loadCompareList();
    }

    public function loadCompareList()
    {
        // Get product IDs from session (default to empty array)
        $compareIds = Session::get('compare', []);

        // Fetch products matching those IDs
        if (!empty($compareIds)) {
            $this->products = Product::whereIn('id', $compareIds)->get();
        } else {
            $this->products = collect(); // Empty collection
        }
    }

    public function removeFromCompare($productId)
    {
        $compareIds = Session::get('compare', []);

        // Remove the ID from the array
        if (($key = array_search($productId, $compareIds)) !== false) {
            unset($compareIds[$key]);
        }

        // Update session and reload list
        Session::put('compare', array_values($compareIds));
        $this->loadCompareList();

        $this->dispatch('compareUpdated'); // Optional: Update a counter in your header
    }

    public function addToCart($productId)
    {
        // For simple cards, we usually add 1 qty with no variants
        $this->handleAddToCart($productId);
    }

    public function render()
    {
        return view('livewire.frontend.compare.index');
    }
}
