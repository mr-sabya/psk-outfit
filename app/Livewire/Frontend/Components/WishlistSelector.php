<?php

namespace App\Livewire\Frontend\Components;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class WishlistSelector extends Component
{
    public $productId;
    public $showModal = false;

    // Use this instead of the #[On] attribute
    protected $listeners = ['openWishlistSelector' => 'loadSelector'];

    public function loadSelector($payload)
    {
        // Debug check
        $this->productId = $payload[0];
        $this->showModal = true;
    }

    public function selectList($wishlistId)
    {
        $wishlist = Auth::user()->wishlists()->find($wishlistId);
        $product = Product::find($this->productId);

        if ($wishlist && $product) {
            $wishlist->addProduct($product);
            $this->showModal = false;
            session()->flash('success', "Added to {$wishlist->name}");
        }
    }

    public function render()
    {
        return view('livewire.frontend.components.wishlist-selector', [
            'wishlists' => Auth::check() ? Auth::user()->wishlists : []
        ]);
    }
}