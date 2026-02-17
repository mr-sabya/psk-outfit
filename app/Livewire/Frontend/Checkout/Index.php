<?php

namespace App\Livewire\Frontend\Checkout;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use Livewire\Component;
use App\Models\{CartItem, Order, OrderItem, Address, ShippingMethod, ShippingRule, PaymentMethod, Country, State, City};
use Illuminate\Support\Facades\{Auth, DB, Session};
use Illuminate\Support\Str;

class Index extends Component
{
    public $shipping_address_id;
    public $shipping_method_id;
    public $payment_method_id;
    public $transaction_id;
    public $bill_to_different_address = false;
    public $order_notes;
    public $agree_terms = false;

    public $shipping = [
        'full_name' => '',
        'email' => '',
        'phone' => '',
        'address_line_1' => '',
        'country_id' => '',
        'state_id' => '',
        'city_id' => '',
        'zip_code' => ''
    ];

    public $billing = [
        'full_name' => '',
        'email' => '',
        'phone' => '',
        'address_line_1' => '',
        'zip_code' => ''
    ];

    public function mount()
    {
        if ($this->getCartQuery()->count() === 0) return redirect()->route('shop');

        $bangladesh = Country::where('name', 'Bangladesh')->first();
        if ($bangladesh) {
            $this->shipping['country_id'] = $bangladesh->id;
        }

        if (Auth::check()) {
            $defaultAddress = Address::where('user_id', Auth::id())->where('is_default', true)->first()
                ?? Address::where('user_id', Auth::id())->first();
            $this->shipping_address_id = $defaultAddress?->id;
        }

        $this->shipping_method_id = ShippingMethod::where('is_default', true)->value('id') ?? ShippingMethod::where('status', true)->value('id');
        $this->syncPaymentMethod();
    }

    public function syncPaymentMethod()
    {
        $method = ShippingMethod::with('paymentMethods')->find($this->shipping_method_id);
        if ($method) {
            $allowed = $method->paymentMethods->where('status', true);
            if (!$allowed->contains('id', $this->payment_method_id)) {
                $this->payment_method_id = $allowed->first()?->id;
            }
        }
    }

    private function getCartQuery()
    {
        return Auth::check() ? CartItem::where('user_id', Auth::id()) : CartItem::where('session_id', Session::getId());
    }

    public function updatedShippingMethodId()
    {
        $this->syncPaymentMethod();
        $this->calculateShipping();
    }

    public function calculateShipping()
    {
        if (!$this->shipping_method_id) return 0;
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
        $rule = ShippingRule::where('shipping_method_id', $this->shipping_method_id)->where('country_id', $c_id)->where(function ($query) use ($s_id, $ct_id) {
            $query->where('city_id', $ct_id)->orWhere(fn($q) => $q->where('state_id', $s_id)->whereNull('city_id'))->orWhere(fn($q) => $q->whereNull('state_id')->whereNull('city_id'));
        })->orderByRaw('city_id DESC, state_id DESC')->first();
        return $rule ? $rule->cost : 0;
    }

    public function render()
    {
        $cartItems = $this->getCartQuery()->with(['product.vendor'])->get();
        $shipping_cost = $this->calculateShipping();
        $subtotal = $cartItems->sum(fn($i) => $i->product->effective_price * $i->quantity);
        $selectedShipping = ShippingMethod::with('paymentMethods')->find($this->shipping_method_id);
        $paymentMethods = $selectedShipping ? $selectedShipping->paymentMethods->where('status', true) : collect();

        return view('livewire.frontend.checkout.index', [
            'addresses' => Auth::check() ? Address::where('user_id', Auth::id())->get() : [],
            'countries' => Country::all(),
            'states' => $this->shipping['country_id'] ? State::where('country_id', $this->shipping['country_id'])->get() : [],
            'cities' => $this->shipping['state_id'] ? City::where('state_id', $this->shipping['state_id'])->get() : [],
            'shippingMethods' => ShippingMethod::where('status', true)->get(),
            'paymentMethods' => $paymentMethods,
            'selectedPayment' => PaymentMethod::find($this->payment_method_id),
            'groupedItems' => $cartItems->groupBy(fn($item) => $item->product->vendor->name ?? 'Global Store'),
            'subtotal' => $subtotal,
            'shipping_cost' => $shipping_cost,
            'total' => $subtotal + $shipping_cost,
        ]);
    }

    public function placeOrder()
    {
        $this->validate([
            'shipping_method_id' => 'required',
            'payment_method_id' => 'nullable|exists:payment_methods,id',
            'agree_terms' => 'accepted',
        ]);

        if (Auth::check() && $this->shipping_address_id) {
            $sAddr = Address::find($this->shipping_address_id);
            $shipData = ['name' => $sAddr->first_name . ' ' . $sAddr->last_name, 'email' => Auth::user()->email, 'phone' => $sAddr->phone, 'address' => $sAddr->address_line_1, 'country_id' => $sAddr->country_id, 'zip' => $sAddr->zip_code];
        } else {
            $this->validate(['shipping.full_name' => 'required', 'shipping.phone' => 'required', 'shipping.address_line_1' => 'required']);
            $shipData = ['name' => $this->shipping['full_name'], 'email' => $this->shipping['email'], 'phone' => $this->shipping['phone'], 'address' => $this->shipping['address_line_1'], 'country_id' => $this->shipping['country_id'], 'zip' => $this->shipping['zip_code']];
        }

        $billData = $this->bill_to_different_address ? ['name' => $this->billing['full_name'], 'email' => $this->billing['email'] ?: $shipData['email'], 'phone' => $this->billing['phone'] ?: $shipData['phone'], 'address' => $this->billing['address_line_1'], 'zip' => $this->billing['zip_code'] ?: $shipData['zip']] : $shipData;

        // FIXED: Return the order object directly from the transaction
        $order = DB::transaction(function () use ($shipData, $billData) {
            $cartItems = $this->getCartQuery()->with('product')->get();
            $payment = $this->payment_method_id ? PaymentMethod::find($this->payment_method_id) : null;
            $shipMethod = ShippingMethod::findOrFail($this->shipping_method_id);
            $subtotal = $cartItems->sum(fn($i) => $i->product->effective_price * $i->quantity);
            $shippingCost = $this->calculateShipping();

            $newOrder = Order::create([
                'user_id' => Auth::id(),
                'vendor_id' => null, // Single Vendor
                'order_number' => '#' . strtoupper(Str::random(10)),
                'order_status' => 'pending',
                'payment_status' => 'pending',
                'shipping_first_name' => $shipData['name'],
                'shipping_last_name' => '',
                'shipping_email' => $shipData['email'],
                'shipping_phone' => $shipData['phone'],
                'shipping_address_line_1' => $shipData['address'],
                'shipping_country_id' => $shipData['country_id'],
                'shipping_zip_code' => $shipData['zip'],
                'billing_first_name' => $billData['name'],
                'billing_last_name' => '',
                'billing_email' => $billData['email'],
                'billing_phone' => $billData['phone'],
                'billing_address_line_1' => $billData['address'],
                'billing_zip_code' => $billData['zip'],
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'total_amount' => $subtotal + $shippingCost,
                'payment_method_id' => $payment?->id,
                'payment_method_name' => $payment?->name ?? 'None',
                'transaction_id' => $this->transaction_id,
                'shipping_method_id' => $shipMethod->id,
                'shipping_method_name' => $shipMethod->name,
                'order_notes' => $this->order_notes,
                'placed_at' => now(),
            ]);

            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $newOrder->id,
                    'vendor_id' => null,
                    'product_id' => $cartItem->product_id,
                    'item_name' => $cartItem->product->name,
                    'quantity' => $cartItem->quantity,
                    'unit_price' => $cartItem->product->effective_price,
                    'subtotal' => $cartItem->product->effective_price * $cartItem->quantity,
                ]);
            }

            $this->getCartQuery()->delete();
            return $newOrder; // Return the created object
        });

        // Ensure order is an object before calling order_number
        if ($order) {
            // We strip the '#' just for the URL parameter
            $cleanNumber = str_replace('#', '', $order->order_number);
            return $this->redirect(route('checkout.success', ['order_number' => $cleanNumber]), navigate: true);
        }
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
    }
}
