<?php

namespace App\Livewire\Frontend\Cart;

use Livewire\Component;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class Index extends Component
{
    public $cartItems;

    #[On('cartUpdated')]
    public function render()
    {
        if (!Auth::check()) {
            return view('livewire.frontend.cart.index', ['groupedItems' => [], 'subtotal' => 0]);
        }

        // Get items with product and vendor details
        $this->cartItems = CartItem::with(['product.vendor'])
            ->where('user_id', Auth::id())
            ->get();

        // Group items by Vendor Name
        $groupedItems = $this->cartItems->groupBy(function ($item) {
            return $item->product->vendor->name ?? 'Global Store';
        });

        $subtotal = $this->cartItems->sum(function ($item) {
            return ($item->product->effective_price ?? 0) * $item->quantity;
        });

        return view('livewire.frontend.cart.index', [
            'groupedItems' => $groupedItems,
            'subtotal' => $subtotal,
            'tax' => 0, // Calculate based on your logic
            'discount' => 0, // Handle coupon logic here
            'total' => $subtotal // subtotal + tax - discount
        ]);
    }

    public function increment($id)
    {
        $item = CartItem::where('user_id', Auth::id())->findOrFail($id);
        $item->increment('quantity');
        $this->dispatch('cartUpdated');
    }

    public function decrement($id)
    {
        $item = CartItem::where('user_id', Auth::id())->findOrFail($id);
        if ($item->quantity > 1) {
            $item->decrement('quantity');
            $this->dispatch('cartUpdated');
        }
    }

    public function removeItem($id)
    {
        CartItem::where('user_id', Auth::id())->where('id', $id)->delete();
        $this->dispatch('cartUpdated');
    }
}
