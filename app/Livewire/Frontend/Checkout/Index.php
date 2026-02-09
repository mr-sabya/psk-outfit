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

    // Guest / New Address Fields (Matches your design style)
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

    // Billing Fields
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
        // 1. Check Cart (User or Guest)
        if ($this->getCartQuery()->count() === 0) return redirect()->route('shop');

        // 2. Load Defaults for Auth Users
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
        return Auth::check()
            ? CartItem::where('user_id', Auth::id())
            : CartItem::where('session_id', Session::getId());
    }

    public function updated($propertyName)
    {
        if (Str::startsWith($propertyName, 'shipping.')) {
            $this->calculateShipping();
        }
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
                ) {
                    return true;
                }
            }
        }
        return false;
    }

    public function calculateShipping()
    {
        if (!$this->shipping_method_id) return 0;

        $cartItems = $this->getCartQuery()->get();
        if ($this->isEligibleForFreeShipping($cartItems)) return 0;

        // Logic to get location for Rule calculation
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
                $query->where('city_id', $ct_id)
                    ->orWhere(fn($q) => $q->where('state_id', $s_id)->whereNull('city_id'))
                    ->orWhere(fn($q) => $q->whereNull('state_id')->whereNull('city_id'));
            })
            ->orderByRaw('city_id DESC, state_id DESC')->first();

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

        return view('livewire.frontend.checkout.index', [
            'addresses' => Auth::check() ? Address::where('user_id', Auth::id())->get() : [],
            'countries' => Country::all(),
            'states' => $this->shipping['country_id'] ? State::where('country_id', $this->shipping['country_id'])->get() : [],
            'cities' => $this->shipping['state_id'] ? City::where('state_id', $this->shipping['state_id'])->get() : [],
            'shippingMethods' => ShippingMethod::where('status', true)->get(),
            'paymentMethods' => PaymentMethod::where('status', true)->get(),
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
        $payment = PaymentMethod::findOrFail($this->payment_method_id);
        $shipMethod = ShippingMethod::findOrFail($this->shipping_method_id);

        $rules = [
            'shipping_method_id' => 'required',
            'payment_method_id' => 'required',
            'agree_terms' => 'accepted',
        ];

        // Validate based on Auth vs Guest
        if (Auth::check() && $this->shipping_address_id) {
            $rules['shipping_address_id'] = 'required';
            $addrData = Address::find($this->shipping_address_id)->toArray();
        } else {
            $rules['shipping.first_name'] = 'required|string';
            $rules['shipping.email'] = 'required|email';
            $rules['shipping.phone'] = 'required';
            $rules['shipping.address_line_1'] = 'required';
            $rules['shipping.country_id'] = 'required';
            $addrData = $this->shipping;
        }

        if ($payment->type === 'direct') $rules['transaction_id'] = 'required|string|min:5';
        $this->validate($rules);

        $cartItems = $this->getCartQuery()->with(['product', 'mainProduct'])->get();
        $groupedItems = $cartItems->groupBy(fn($item) => $item->product->vendor_id ?: 1);

        DB::transaction(function () use ($groupedItems, $addrData, $shipMethod, $payment) {
            foreach ($groupedItems as $vendorId => $items) {
                $orderSubtotal = $items->sum(function ($cartItem) {
                    $price = $cartItem->product->effective_price;
                    if ($cartItem->is_combo && $cartItem->main_product_id && $cartItem->product_id != $cartItem->main_product_id) {
                        $price = $cartItem->mainProduct?->getComboDiscount($cartItem->product_id) ?? $price;
                    }
                    return $price * $cartItem->quantity;
                });

                $order = Order::create([
                    'user_id' => Auth::id(),
                    'vendor_id' => $vendorId,
                    'order_number' => '#' . strtoupper(Str::random(10)),
                    'order_status' => OrderStatus::Pending,
                    'payment_status' => PaymentStatus::Pending,
                    'shipping_first_name' => $addrData['first_name'],
                    'shipping_last_name' => $addrData['last_name'] ?? '',
                    'shipping_email' => $addrData['email'],
                    'shipping_phone' => $addrData['phone'],
                    'shipping_address_line_1' => $addrData['address_line_1'],
                    'shipping_country_id' => $addrData['country_id'],
                    'shipping_state_id' => $addrData['state_id'],
                    'shipping_city_id' => $addrData['city_id'],
                    'shipping_zip_code' => $addrData['zip_code'],
                    'billing_first_name' => $this->bill_to_different_address ? $this->billing['first_name'] : $addrData['first_name'],
                    'billing_last_name' => $this->bill_to_different_address ? $this->billing['last_name'] : $addrData['last_name'],
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
                    $unitPrice = $cartItem->product->effective_price;
                    if ($cartItem->is_combo && $cartItem->main_product_id && $cartItem->product_id != $cartItem->main_product_id) {
                        $unitPrice = $cartItem->mainProduct?->getComboDiscount($cartItem->product_id) ?? $unitPrice;
                    }
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $cartItem->product_id,
                        'item_name' => $cartItem->product->name,
                        'item_sku' => $cartItem->product->sku,
                        'quantity' => $cartItem->quantity,
                        'unit_price' => $unitPrice,
                        'subtotal' => $unitPrice * $cartItem->quantity,
                        'item_attributes' => $cartItem->options,
                    ]);
                }
            }
            $this->getCartQuery()->delete();
        });

        return redirect()->route('user.checkout.success');
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
