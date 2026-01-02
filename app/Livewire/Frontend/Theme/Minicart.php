<?php

namespace App\Livewire\Frontend\Theme;

use Livewire\Component;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class Minicart extends Component
{
    /**
     * Listen for the 'cartUpdated' event from any other component 
     * (like Product Card or Shop Details) to refresh the cart list.
     */
    #[On('cartUpdated')]
    public function render()
    {
        $cartItems = [];
        $subtotal = 0;
        $count = 0;

        if (Auth::check()) {
            // Fetch cart items with product relationship to avoid N+1 queries
            $cartItems = CartItem::with('product')
                ->where('user_id', Auth::id())
                ->latest()
                ->get();

            $subtotal = $cartItems->sum(function ($item) {
                return ($item->product->effective_price ?? 0) * $item->quantity;
            });

            $count = $cartItems->count();
        }

        return view('livewire.frontend.theme.minicart', [
            'cartItems' => $cartItems,
            'subtotal'  => $subtotal,
            'count'     => $count,
        ]);
    }

    // ... inside the Minicart class

    public function incrementQuantity($itemId)
    {
        if (Auth::check()) {
            $item = CartItem::where('user_id', Auth::id())->find($itemId);
            if ($item) {
                $item->increment('quantity');
                $this->dispatch('cartUpdated');
            }
        }
    }

    public function decrementQuantity($itemId)
    {
        if (Auth::check()) {
            $item = CartItem::where('user_id', Auth::id())->find($itemId);
            if ($item && $item->quantity > 1) {
                $item->decrement('quantity');
                $this->dispatch('cartUpdated');
            } else {
                // Optional: if quantity is 1 and they press minus, remove it
                $this->removeItem($itemId);
            }
        }
    }

    /**
     * Remove an item from the database cart
     */
    public function removeItem($cartItemId)
    {
        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())
                ->where('id', $cartItemId)
                ->delete();

            // Refresh the component
            $this->dispatch('cartUpdated');

            // Optional: Dispatch a browser notification
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Item removed from cart'
            ]);
        }
    }
}
