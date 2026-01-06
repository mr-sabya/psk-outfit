<?php

namespace App\Livewire\Frontend\Checkout;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use Livewire\Component;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use App\Models\ShippingMethod;
use App\Models\ShippingRule;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        if (!Auth::check()) return redirect()->route('login');

        $cartCount = CartItem::where('user_id', Auth::id())->count();
        if ($cartCount === 0) return redirect()->route('shop');

        // 1. Load default address
        $defaultAddress = Address::where('user_id', Auth::id())->where('is_default', true)->first()
            ?? Address::where('user_id', Auth::id())->first();
        $this->shipping_address_id = $defaultAddress?->id;

        // 2. Load default Shipping Method
        $defaultShip = ShippingMethod::where('is_default', true)->first() ?? ShippingMethod::where('status', true)->first();
        $this->shipping_method_id = $defaultShip?->id;

        // 3. Load default Payment Method
        $defaultPay = PaymentMethod::where('is_default', true)->first() ?? PaymentMethod::where('status', true)->first();
        $this->payment_method_id = $defaultPay?->id;
    }

    // Recalculate shipping whenever address or method changes
    public function updatedShippingAddressId()
    {
        $this->calculateShipping();
    }
    public function updatedShippingMethodId()
    {
        $this->calculateShipping();
    }

    // --- Helper: Check for Free Shipping Eligibility ---
    private function isEligibleForFreeShipping($items)
    {
        foreach ($items as $item) {
            $p = $item->product;
            // Check threshold
            if ($p->free_delivery_threshold && $item->quantity >= $p->free_delivery_threshold) {
                $now = Carbon::now();
                // Check Promotion Dates
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
        if (!$this->shipping_address_id || !$this->shipping_method_id) return 0;

        // NEW: Check if cart qualifies for Free Shipping based on Bundle/Promo Rules
        $cartItems = CartItem::where('user_id', Auth::id())->get();
        if ($this->isEligibleForFreeShipping($cartItems)) {
            return 0;
        }

        $address = Address::find($this->shipping_address_id);

        // Find the most specific shipping rule (City -> State -> Country)
        $rule = ShippingRule::where('shipping_method_id', $this->shipping_method_id)
            ->where('country_id', $address->country_id)
            ->where(function ($query) use ($address) {
                $query->where('city_id', $address->city_id)
                    ->orWhere(function ($q) use ($address) {
                        $q->where('state_id', $address->state_id)->whereNull('city_id');
                    })
                    ->orWhere(function ($q) {
                        $q->whereNull('state_id')->whereNull('city_id');
                    });
            })
            ->orderByRaw('city_id DESC, state_id DESC')
            ->first();

        return $rule ? $rule->cost : 0;
    }

    public function render()
    {
        // Load mainProduct relationship to use Rule 2 (dynamic discount lookup)
        $cartItems = CartItem::with(['product.vendor', 'mainProduct'])->where('user_id', Auth::id())->get();
        $groupedItems = $cartItems->groupBy(fn($item) => $item->product->vendor->name ?? 'Global Store');

        // UPDATED: Standard Subtotal calculation using Rule 2 logic
        $subtotal = $cartItems->sum(function ($item) {
            $price = $item->product->effective_price;
            
            if ($item->is_combo && $item->main_product_id) {
                // If it's the bundled item (not the main one), pull special price
                if ($item->product_id != $item->main_product_id) {
                    $mainProduct = $item->mainProduct;
                    if ($mainProduct) {
                        $price = $mainProduct->getComboDiscount($item->product_id) ?? $price;
                    }
                }
            }
            return $price * $item->quantity;
        });

        $tax = 0;
        $discount = 0;
        $shipping_cost = $this->calculateShipping();
        $total = ($subtotal + $tax + $shipping_cost) - $discount;

        return view('livewire.frontend.checkout.index', [
            'addresses' => Address::where('user_id', Auth::id())->get(),
            'shippingMethods' => ShippingMethod::where('status', true)->get(),
            'paymentMethods' => PaymentMethod::where('status', true)->get(),
            'selectedPayment' => PaymentMethod::find($this->payment_method_id),
            'groupedItems' => $groupedItems,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'discount' => $discount,
            'shipping_cost' => $shipping_cost,
            'total' => $total,
            'freeShippingActive' => ($shipping_cost == 0 && $this->isEligibleForFreeShipping($cartItems))
        ]);
    }

    public function incrementQuantity($itemId)
    {
        $cartItem = CartItem::where('id', $itemId)->where('user_id', Auth::id())->first();
        if ($cartItem) {
            $cartItem->increment('quantity');
        }
    }

    public function decrementQuantity($itemId)
    {
        $cartItem = CartItem::where('id', $itemId)->where('user_id', Auth::id())->first();
        if ($cartItem && $cartItem->quantity > 1) {
            $cartItem->decrement('quantity');
        } elseif ($cartItem && $cartItem->quantity <= 1) {
            $cartItem->delete();
            if (CartItem::where('user_id', Auth::id())->count() === 0) {
                return redirect()->route('shop');
            }
        }
    }

    public function removeItem($itemId)
    {
        CartItem::where('id', $itemId)->where('user_id', Auth::id())->delete();
        if (CartItem::where('user_id', Auth::id())->count() === 0) {
            return redirect()->route('shop');
        }
    }

    public function placeOrder()
    {
        // 1. Validation
        $payment = PaymentMethod::findOrFail($this->payment_method_id);
        $shipMethod = ShippingMethod::findOrFail($this->shipping_method_id);

        $rules = [
            'shipping_address_id' => 'required',
            'shipping_method_id' => 'required',
            'payment_method_id' => 'required',
            'agree_terms' => 'accepted',
        ];

        if ($payment->type === 'direct') {
            $rules['transaction_id'] = 'required|string|min:5';
        }
        $this->validate($rules);

        // 2. Prepare Data
        $addr = Address::findOrFail($this->shipping_address_id);
        $cartItems = CartItem::with(['product', 'mainProduct'])->where('user_id', Auth::id())->get();

        $groupedItems = $cartItems->groupBy(function ($item) {
            return $item->product->vendor_id ?: 1;
        });

        DB::transaction(function () use ($groupedItems, $addr, $shipMethod, $payment) {
            foreach ($groupedItems as $vendorId => $items) {

                $currentVendorId = (int) $vendorId;

                // UPDATED: Calculate specific vendor subtotal using Rule 2 logic
                $orderSubtotal = $items->sum(function ($cartItem) {
                    $price = $cartItem->product->effective_price;
                    if ($cartItem->is_combo && $cartItem->main_product_id) {
                        if ($cartItem->product_id != $cartItem->main_product_id) {
                            $main = $cartItem->mainProduct;
                            $price = $main ? ($main->getComboDiscount($cartItem->product_id) ?? $price) : $price;
                        }
                    }
                    return $price * $cartItem->quantity;
                });

                // Calculate shipping for this specific vendor
                $orderShipping = $this->isEligibleForFreeShipping($items) ? 0 : $this->calculateShipping();

                // 3. Create the Order
                $order = Order::create([
                    'user_id' => Auth::id(),
                    'vendor_id' => $currentVendorId,
                    'order_status' => OrderStatus::Pending,
                    'payment_status' => PaymentStatus::Pending,

                    'shipping_first_name' => $addr->first_name,
                    'shipping_last_name' => $addr->last_name,
                    'shipping_email' => $addr->email,
                    'shipping_phone' => $addr->phone,
                    'shipping_address_line_1' => $addr->address_line_1,
                    'shipping_country_id' => $addr->country_id,
                    'shipping_state_id' => $addr->state_id,
                    'shipping_city_id' => $addr->city_id,
                    'shipping_zip_code' => $addr->zip_code,

                    'billing_first_name' => $this->bill_to_different_address ? $this->billing['first_name'] : $addr->first_name,
                    'billing_last_name' => $this->bill_to_different_address ? $this->billing['last_name'] : $addr->last_name,
                    'billing_address_line_1' => $this->bill_to_different_address ? $this->billing['address_line_1'] : $addr->address_line_1,
                    'billing_zip_code' => $this->bill_to_different_address ? $this->billing['zip_code'] : $addr->zip_code,
                    'billing_country_id' => $addr->country_id,
                    'billing_state_id' => $addr->state_id,
                    'billing_city_id' => $addr->city_id,

                    'subtotal' => $orderSubtotal,
                    'shipping_cost' => $orderShipping,
                    'total_amount' => $orderSubtotal + $orderShipping,
                    'payment_method_id' => $payment->id,
                    'payment_method_name' => $payment->name,
                    'transaction_id' => $this->transaction_id,
                    'shipping_method_id' => $shipMethod->id,
                    'shipping_method_name' => $shipMethod->name,
                    'placed_at' => now(),
                ]);

                // 4. Create Order Items
                foreach ($items as $cartItem) {
                    $unitPrice = $cartItem->product->effective_price;

                    // Apply Rule 2: Combo pricing for Order Items
                    if ($cartItem->is_combo && $cartItem->main_product_id) {
                        if ($cartItem->product_id != $cartItem->main_product_id) {
                            $main = $cartItem->mainProduct;
                            $unitPrice = $main ? ($main->getComboDiscount($cartItem->product_id) ?? $unitPrice) : $unitPrice;
                        }
                    }

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $cartItem->product_id,
                        'vendor_id' => $currentVendorId,
                        'item_name' => $cartItem->product->name,
                        'item_sku' => $cartItem->product->sku,
                        'item_attributes' => $cartItem->options,
                        'quantity' => $cartItem->quantity,
                        'unit_price' => $unitPrice,
                        'subtotal' => $unitPrice * $cartItem->quantity,
                        'item_discount_amount' => 0,
                        'item_tax_amount' => 0,
                        'commission_rate' => 0,
                        'commission_amount' => 0,
                    ]);
                }
            }
            CartItem::where('user_id', Auth::id())->delete();
        });

        return redirect()->route('user.checkout.success');
    }
}