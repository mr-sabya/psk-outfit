<?php

namespace App\Livewire\Frontend\Checkout;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use Livewire\Component;
use App\Models\{CartItem, Order, OrderItem, Address, ShippingMethod, ShippingRule, PaymentMethod, Country, State, City};
use Illuminate\Support\Facades\{Auth, DB, Session};
use Illuminate\Support\Str;
use Carbon\Carbon;

class Index extends Component
{
    // Form States
    public $shipping_address_id;
    public $shipping_method_id;
    public $payment_method_id;
    public $transaction_id;
    public $bill_to_different_address = false;
    public $order_notes;
    public $agree_terms = false;

    public $shipping = [
        'first_name' => '',
        'last_name' => '',
        'email' => '',
        'phone' => '',
        'address_line_1' => '',
        'country_id' => '',
        'state_id' => '',
        'city_id' => '',
        'zip_code' => ''
    ];

    public $billing = [
        'first_name' => '',
        'last_name' => '',
        'email' => '',
        'phone' => '',
        'address_line_1' => '',
        'zip_code' => ''
    ];

    public function mount()
    {
        if ($this->getCartQuery()->count() === 0) return redirect()->route('shop');

        if (Auth::check()) {
            $defaultAddress = Address::where('user_id', Auth::id())->where('is_default', true)->first()
                ?? Address::where('user_id', Auth::id())->first();
            $this->shipping_address_id = $defaultAddress?->id;
        }

        $this->shipping_method_id = ShippingMethod::where('is_default', true)->value('id') ?? ShippingMethod::where('status', true)->value('id');
        $this->payment_method_id = PaymentMethod::where('is_default', true)->value('id') ?? PaymentMethod::where('status', true)->value('id');
    }

    private function getCartQuery()
    {
        return Auth::check() ? CartItem::where('user_id', Auth::id()) : CartItem::where('session_id', Session::getId());
    }

    public function updated($propertyName)
    {
        if (Str::startsWith($propertyName, 'shipping.')) $this->calculateShipping();
    }

    public function updatedShippingAddressId()
    {
        $this->calculateShipping();
    }
    public function updatedShippingMethodId()
    {
        $this->calculateShipping();
    }

    private function isEligibleForFreeShipping($items)
    {
        foreach ($items as $item) {
            $p = $item->product;
            if ($p->free_delivery_threshold && $item->quantity >= $p->free_delivery_threshold) {
                $now = Carbon::now();
                if ((!$p->free_delivery_starts_at || $now->gte($p->free_delivery_starts_at)) &&
                    (!$p->free_delivery_ends_at || $now->lte($p->free_delivery_ends_at))
                ) return true;
            }
        }
        return false;
    }

    public function calculateShipping()
    {
        if (!$this->shipping_method_id) return 0;
        $cartItems = $this->getCartQuery()->get();
        if ($this->isEligibleForFreeShipping($cartItems)) return 0;

        if (Auth::check() && $this->shipping_address_id) {
            $addr = Address::find($this->shipping_address_id);
            $c_id = $addr?->country_id;
            $s_id = $addr?->state_id;
            $ct_id = $addr?->city_id;
        } else {
            $c_id = $this->shipping['country_id'];
            $s_id = $this->shipping['state_id'];
            $ct_id = $this->shipping['city_id'];
        }

        if (!$c_id) return 0;
        $rule = ShippingRule::where('shipping_method_id', $this->shipping_method_id)
            ->where('country_id', $c_id)
            ->where(function ($query) use ($s_id, $ct_id) {
                $query->where('city_id', $ct_id)->orWhere(fn($q) => $q->where('state_id', $s_id)->whereNull('city_id'))->orWhere(fn($q) => $q->whereNull('state_id')->whereNull('city_id'));
            })->orderByRaw('city_id DESC, state_id DESC')->first();
        return $rule ? $rule->cost : 0;
    }

    public function render()
    {
        $cartItems = $this->getCartQuery()->with(['product.vendor', 'mainProduct'])->get();
        $groupedItems = $cartItems->groupBy(fn($item) => $item->product->vendor->name ?? 'Global Store');

        $subtotal = $cartItems->sum(function ($item) {
            $price = $item->product->effective_price;
            if ($item->is_combo && $item->main_product_id && $item->product_id != $item->main_product_id) {
                $price = $item->mainProduct?->getComboDiscount($item->product_id) ?? $price;
            }
            return $price * $item->quantity;
        });

        $shipping_cost = $this->calculateShipping();

        // --- START FILTER LOGIC ---
        $shippingMethods = ShippingMethod::where('status', true)->get();
        $paymentMethodsQuery = PaymentMethod::where('status', true);

        // Check if selected shipping method is 'pay-now'
        $selectedShipping = $shippingMethods->firstWhere('id', $this->shipping_method_id);

        if ($selectedShipping && $selectedShipping->slug === 'pay-now') {
            // Only show Online/Direct payments (Exclude COD)
            $paymentMethodsQuery->where('type', 'direct');

            // If current payment_method_id is now invalid (e.g. was COD), reset it
            $availableIds = (clone $paymentMethodsQuery)->pluck('id')->toArray();
            if (!in_array($this->payment_method_id, $availableIds)) {
                $this->payment_method_id = $availableIds[0] ?? null;
            }
        }
        $paymentMethods = $paymentMethodsQuery->get();
        // --- END FILTER LOGIC ---

        return view('livewire.frontend.checkout.index', [
            'addresses' => Auth::check() ? Address::where('user_id', Auth::id())->get() : [],
            'countries' => Country::all(),
            'states' => $this->shipping['country_id'] ? State::where('country_id', $this->shipping['country_id'])->get() : [],
            'cities' => $this->shipping['state_id'] ? City::where('state_id', $this->shipping['state_id'])->get() : [],
            'shippingMethods' => $shippingMethods,
            'paymentMethods' => $paymentMethods,
            'selectedPayment' => PaymentMethod::find($this->payment_method_id),
            'groupedItems' => $groupedItems,
            'subtotal' => $subtotal,
            'tax' => 0,
            'discount' => 0,
            'shipping_cost' => $shipping_cost,
            'total' => $subtotal + $shipping_cost,
            'freeShippingActive' => ($shipping_cost == 0 && $this->isEligibleForFreeShipping($cartItems))
        ]);
    }

    public function placeOrder()
    {
        $this->validate([
            'shipping_method_id' => 'required',
            'payment_method_id' => 'required',
            'agree_terms' => 'accepted',
        ]);

        $payment = PaymentMethod::findOrFail($this->payment_method_id);
        $shipMethod = ShippingMethod::findOrFail($this->shipping_method_id);

        if (Auth::check() && $this->shipping_address_id) {
            $addrData = Address::find($this->shipping_address_id)->toArray();
        } else {
            $this->validate([
                'shipping.first_name' => 'required',
                'shipping.email' => 'required|email',
                'shipping.phone' => 'required',
                'shipping.address_line_1' => 'required',
                'shipping.country_id' => 'required',
            ]);
            $addrData = $this->shipping;
        }

        if ($payment->type === 'direct') {
            $this->validate(['transaction_id' => 'required|min:5']);
        }

        DB::transaction(function () use ($addrData, $shipMethod, $payment) {
            $cartItems = $this->getCartQuery()->with(['product', 'mainProduct'])->get();
            $grouped = $cartItems->groupBy(fn($item) => $item->product->vendor_id ?: 1);

            foreach ($grouped as $vendorId => $items) {
                $orderSubtotal = $items->sum(fn($i) => $i->product->effective_price * $i->quantity);
                $order = Order::create([
                    'user_id' => Auth::id(),
                    'vendor_id' => $vendorId,
                    'order_number' => '#' . strtoupper(Str::random(10)),
                    'order_status' => OrderStatus::Pending,
                    'payment_status' => PaymentStatus::Pending,
                    'shipping_first_name' => $addrData['first_name'],
                    'shipping_email' => $addrData['email'],
                    'shipping_phone' => $addrData['phone'],
                    'shipping_address_line_1' => $addrData['address_line_1'],
                    'shipping_country_id' => $addrData['country_id'],
                    'subtotal' => $orderSubtotal,
                    'shipping_cost' => $this->calculateShipping(),
                    'total_amount' => $orderSubtotal + $this->calculateShipping(),
                    'payment_method_id' => $payment->id,
                    'payment_method_name' => $payment->name,
                    'transaction_id' => $this->transaction_id,
                    'shipping_method_id' => $shipMethod->id,
                    'shipping_method_name' => $shipMethod->name,
                    'placed_at' => now(),
                ]);

                foreach ($items as $cartItem) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $cartItem->product_id,
                        'item_name' => $cartItem->product->name,
                        'quantity' => $cartItem->quantity,
                        'unit_price' => $cartItem->product->effective_price,
                        'subtotal' => $cartItem->product->effective_price * $cartItem->quantity,
                    ]);
                }
            }
            $this->getCartQuery()->delete();
        });

        return redirect()->route('checkout.success');
    }

    public function incrementQuantity($id)
    {
        $item = $this->getCartQuery()->find($id);
        if ($item) $item->increment('quantity');
    }
    public function decrementQuantity($id)
    {
        $item = $this->getCartQuery()->find($id);
        if ($item && $item->quantity > 1) $item->decrement('quantity');
        else $this->removeItem($id);
    }
    public function removeItem($id)
    {
        $this->getCartQuery()->where('id', $id)->delete();
        if ($this->getCartQuery()->count() === 0) return redirect()->route('shop');
    }
}
