<?php

namespace App\Livewire\Frontend\Theme;

use Livewire\Component;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\On;

class Minicart extends Component
{
    #[On('cartUpdated')]
    public function render()
    {
        // 1. Determine identify (User or Guest)
        $query = CartItem::with('product');

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', Session::getId());
        }

        $cartItems = $query->latest()->get();

        // 2. Calculate totals
        $subtotal = $cartItems->sum(function ($item) {
            // Priority: item->price (saved at checkout) or product->effective_price
            $price = $item->price ?? $item->product->effective_price ?? 0;
            return $price * $item->quantity;
        });

        $count = $cartItems->count();

        return view('livewire.frontend.theme.minicart', [
            'cartItems' => $cartItems,
            'subtotal'  => $subtotal,
            'count'     => $count,
        ]);
    }

    /**
     * Helper to find an item ensuring the guest/user owns it
     */
    private function findMyCartItem($itemId)
    {
        $query = CartItem::where('id', $itemId);

        if (Auth::check()) {
            return $query->where('user_id', Auth::id())->first();
        }

        return $query->where('session_id', Session::getId())->first();
    }

    public function incrementQuantity($itemId)
    {
        $item = $this->findMyCartItem($itemId);
        if ($item) {
            $item->increment('quantity');
            $this->dispatch('cartUpdated');
        }
    }

    public function decrementQuantity($itemId)
    {
        $item = $this->findMyCartItem($itemId);
        if ($item && $item->quantity > 1) {
            $item->decrement('quantity');
            $this->dispatch('cartUpdated');
        } else {
            $this->removeItem($itemId);
        }
    }

    public function removeItem($cartItemId)
    {
        $item = $this->findMyCartItem($cartItemId);
        
        if ($item) {
            $item->delete();
            $this->dispatch('cartUpdated');
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Item removed from cart'
            ]);
        }
    }
}