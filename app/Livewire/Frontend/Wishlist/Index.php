<?php

namespace App\Livewire\Frontend\Wishlist;

use App\Livewire\Frontend\Traits\CartTrait;
use App\Livewire\Frontend\Traits\WishlistTrait;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    use WishlistTrait, CartTrait;

    // We use this to track quantities in the UI before adding to cart
    public $quantities = [];

    protected $listeners = ['wishlistUpdated' => '$refresh'];

    public function mount()
    {
        $this->initializeQuantities();
    }

    public function initializeQuantities()
    {
        if (Auth::check()) {
            $wishlistProductIds = Wishlist::where('user_id', Auth::id())->pluck('product_id');
            foreach ($wishlistProductIds as $id) {
                $this->quantities[$id] = 1;
            }
        }
    }

    public function incrementQty($productId)
    {
        $this->quantities[$productId]++;
    }

    public function decrementQty($productId)
    {
        if ($this->quantities[$productId] > 1) {
            $this->quantities[$productId]--;
        }
    }

    public function removeItem($productId)
    {
        $this->toggleWishlist($productId);
        // Page will refresh via listener
    }

    public function moveToCart($productId)
    {
        $qty = $this->quantities[$productId] ?? 1;
        $this->handleAddToCart($productId, $qty);

        // Optional: Remove from wishlist after adding to cart
        $this->removeItem($productId);
    }

    public function render()
    {
        $wishlistItems = [];

        if (Auth::check()) {
            // Fetch wishlist items with product and vendor info
            $wishlistItems = Wishlist::where('user_id', Auth::id())
                ->with(['product.vendor', 'product.reviews'])
                ->get()
                ->groupBy(function ($item) {
                    return $item->product->vendor->name ?? 'Admin Store';
                });
        }

        return view('livewire.frontend.wishlist.index', [
            'wishlistGroups' => $wishlistItems
        ]);
    }
}
