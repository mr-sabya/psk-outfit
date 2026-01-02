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

    public function calculateShipping()
    {
        if (!$this->shipping_address_id || !$this->shipping_method_id) return 0;

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
        $cartItems = CartItem::with(['product.vendor'])->where('user_id', Auth::id())->get();
        $groupedItems = $cartItems->groupBy(fn($item) => $item->product->vendor->name ?? 'Global Store');

        $subtotal = $cartItems->sum(fn($item) => $item->product->effective_price * $item->quantity);
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
        ]);
    }


    // ... inside the Index class

    public function incrementQuantity($itemId)
    {
        $cartItem = CartItem::where('id', $itemId)
            ->where('user_id', Auth::id())
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        }
    }

    public function decrementQuantity($itemId)
    {
        $cartItem = CartItem::where('id', $itemId)
            ->where('user_id', Auth::id())
            ->first();

        if ($cartItem && $cartItem->quantity > 1) {
            $cartItem->decrement('quantity');
        } elseif ($cartItem && $cartItem->quantity <= 1) {
            // Optional: Remove item if it goes below 1
            $cartItem->delete();

            // Redirect if cart becomes empty
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
        $cartItems = CartItem::with(['product.variants.attributeValues.attribute'])->where('user_id', Auth::id())->get();
        // 1. Update the grouping to provide a fallback if vendor_id is null
        $groupedItems = $cartItems->groupBy(function ($item) {
            return $item->product->vendor_id ?: 1; // Default to ID 1 (Admin) if no vendor exists
        });

        DB::transaction(function () use ($groupedItems, $addr, $shipMethod, $payment) {
            foreach ($groupedItems as $vendorId => $items) {

                // Ensure $vendorId is treated as an integer
                $currentVendorId = (int) $vendorId;

                // Calculate totals for this vendor's order
                $orderSubtotal = $items->sum(function ($cartItem) {
                    $variant = $cartItem->product->findVariantByOptions($cartItem->options ?? []);
                    $price = ($variant && $variant->price > 0) ? $variant->price : $cartItem->product->effective_price;
                    return $price * $cartItem->quantity;
                });

                $orderShipping = $this->calculateShipping();

                // 3. Create the Order
                $order = Order::create([
                    'user_id' => Auth::id(),
                    'vendor_id' => $currentVendorId,
                    'order_status' => OrderStatus::Pending,
                    'payment_status' => PaymentStatus::Pending,

                    // Addresses
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
                    'billing_country_id' => $addr->country_id, // Default to shipping country if not specified
                    'billing_state_id' => $addr->state_id,
                    'billing_city_id' => $addr->city_id,

                    // Financials & Methods
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
                    // Determine specific variant (Size + Color)
                    $variant = $cartItem->product->findVariantByOptions($cartItem->options ?? []);
                    $unitPrice = ($variant && $variant->price > 0) ? $variant->price : $cartItem->product->effective_price;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $cartItem->product_id,
                        'product_variant_id' => $variant?->id,
                        'vendor_id' => $currentVendorId,
                        'item_name' => $cartItem->product->name,
                        'item_sku' => $variant ? $variant->sku : $cartItem->product->sku,
                        'item_attributes' => $cartItem->options, // Save the Size/Color selection
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
