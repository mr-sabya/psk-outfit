<?php

namespace App\Livewire\Frontend\Traits;

use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

trait WishlistTrait
{
    /**
     * Toggle a product in the wishlist
     */
    public function toggleWishlist($productId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userId = Auth::id();
        $wishlistItem = Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            $this->dispatch('wishlistUpdated', action: 'removed');
        } else {
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $productId
            ]);
            $this->dispatch('wishlistUpdated', action: 'added');
        }
    }

    /**
     * Check if product is in wishlist for UI state
     */
    public function isInWishlist($productId)
    {
        if (!Auth::check()) return false;

        return Wishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->exists();
    }
}
