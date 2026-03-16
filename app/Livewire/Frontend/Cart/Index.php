<?php

namespace App\Livewire\Frontend\Cart;

use Livewire\Component;
use App\Models\CartItem;
use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\On;

class Index extends Component
{
    public $cartItems;
    public $couponCode;

    #[On('cartUpdated')]
    public function render()
    {
        $query = CartItem::with(['product.categories']);
        Auth::check() ? $query->where('user_id', Auth::id()) : $query->where('session_id', Session::getId());
        $this->cartItems = $query->get();

        $subtotal = $this->cartItems->sum(fn($i) => ($i->price ?? $i->product->effective_price) * $i->quantity);

        $discount = 0;
        $appliedCoupon = null;

        if (Session::has('coupon')) {
            $appliedCoupon = Coupon::where('code', Session::get('coupon')['code'])->active()->first();
            if ($appliedCoupon && $subtotal >= $appliedCoupon->min_spend) {
                $discount = $appliedCoupon->calculateDiscountForCart($this->cartItems, Auth::id());
            } else {
                Session::forget('coupon');
            }
        }

        return view('livewire.frontend.cart.index', [
            'subtotal' => $subtotal,
            'discount' => $discount,
            'appliedCoupon' => $appliedCoupon,
            'tax' => 0,
            'total' => max(0, $subtotal - $discount)
        ]);
    }

    public function applyCoupon()
    {
        $this->validate(['couponCode' => 'required']);
        $coupon = Coupon::active()->where('code', $this->couponCode)->first();

        if (!$coupon) {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Invalid coupon code.']);
            return;
        }

        $subtotal = $this->cartItems->sum(fn($i) => ($i->price ?? $i->product->effective_price) * $i->quantity);
        if ($subtotal < $coupon->min_spend) {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Minimum spend of ৳' . $coupon->min_spend . ' required.']);
            return;
        }

        Session::put('coupon', ['code' => $coupon->code]);
        $this->couponCode = '';
        $this->dispatch('cartUpdated');
    }

    public function removeCoupon()
    {
        Session::forget('coupon');
        $this->dispatch('cartUpdated');
    }

    public function increment($id)
    {
        $this->getAuthorizedItem($id)->increment('quantity');
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
        $this->getAuthorizedItem($id)->delete();
        $this->dispatch('cartUpdated');
    }

    private function getAuthorizedItem($id)
    {
        $query = CartItem::where('id', $id);
        return Auth::check() ? $query->where('user_id', Auth::id())->firstOrFail() : $query->where('session_id', Session::getId())->firstOrFail();
    }
}
