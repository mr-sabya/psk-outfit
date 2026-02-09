<?php

namespace App\Livewire\Frontend\Cart;

use Livewire\Component;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\On;

class Index extends Component
{
    public $cartItems;

    #[On('cartUpdated')]
    public function render()
    {
        // 1. Get items based on Auth or Session
        $query = CartItem::with(['product.vendor']);

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', Session::getId());
        }

        $this->cartItems = $query->get();

        // 2. Group items by Vendor Name
        $groupedItems = $this->cartItems->groupBy(function ($item) {
            // Use 'Global Store' if vendor or vendor name is missing
            return $item->product->vendor->name ?? 'Global Store';
        });

        // 3. Financial Calculations
        $subtotal = $this->cartItems->sum(function ($item) {
            // Priority: Item price (if snapshotted) or product effective price
            $price = $item->price ?? $item->product->effective_price ?? 0;
            return $price * $item->quantity;
        });

        return view('livewire.frontend.cart.index', [
            'groupedItems' => $groupedItems,
            'subtotal' => $subtotal,
            'tax' => 0, // Implement your tax logic here
            'discount' => 0, // Implement your coupon/discount logic here
            'total' => $subtotal // Calculation: ($subtotal + $tax) - $discount
        ]);
    }

    /**
     * Security Helper: Ensures the user/guest owns the item they are trying to modify
     */
    private function getAuthorizedItem($id)
    {
        $query = CartItem::where('id', $id);

        if (Auth::check()) {
            return $query->where('user_id', Auth::id())->firstOrFail();
        }

        return $query->where('session_id', Session::getId())->firstOrFail();
    }

    public function increment($id)
    {
        $item = $this->getAuthorizedItem($id);
        $item->increment('quantity');
        $this->dispatch('cartUpdated');
    }

    public function decrement($id)
    {
        $item = $this->getAuthorizedItem($id);
        if ($item->quantity > 1) {
            $item->decrement('quantity');
            $this->dispatch('cartUpdated');
        } else {
            $this->removeItem($id);
        }
    }

    public function removeItem($id)
    {
        $item = $this->getAuthorizedItem($id);
        $item->delete();

        $this->dispatch('cartUpdated');

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Item removed from cart'
        ]);
    }
}
