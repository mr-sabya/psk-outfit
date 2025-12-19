<?php

namespace App\Livewire\Frontend\Checkout;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use Livewire\Component;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\UserAddress; // Assume this model exists
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    // Form States
    public $shipping_address_id;
    public $bill_to_different_address = false;
    public $order_notes;
    public $shipping_method = 'flat_rate';
    public $payment_method = 'cod';
    public $agree_terms = false;

    // Different Billing Address Fields
    public $billing = [
        'name' => '',
        'email' => '',
        'phone' => '',
        'company' => '',
        'country' => '',
        'city' => '',
        'state' => '',
        'zip' => '',
        'address' => ''
    ];

    public function mount()
    {
        if (!Auth::check()) return redirect()->route('login');

        $cartCount = CartItem::where('user_id', Auth::id())->count();
        if ($cartCount === 0) return redirect()->route('shop');

        // Set default address if exists
        $defaultAddress = Auth::user()->addresses()->where('is_default', true)->first()
            ?? Auth::user()->addresses()->first();
        $this->shipping_address_id = $defaultAddress?->id;
    }

    public function render()
    {
        $cartItems = CartItem::with(['product.vendor'])->where('user_id', Auth::id())->get();

        $groupedItems = $cartItems->groupBy(function ($item) {
            return $item->product->vendor->name ?? 'Global Store';
        });

        $subtotal = $cartItems->sum(fn($item) => $item->product->effective_price * $item->quantity);
        $tax = 0; // Logic for tax
        $discount = 0; // Logic for discount/coupons

        // Shipping Logic
        $shipping_cost = match ($this->shipping_method) {
            'flat_rate' => 15.00,
            'local_pickup' => 19.00,
            'free_shipping' => 0.00,
            default => 0.00
        };

        $total = ($subtotal + $tax + $shipping_cost) - $discount;

        return view('livewire.frontend.checkout.index', [
            'addresses' => Auth::user()->addresses,
            'groupedItems' => $groupedItems,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'discount' => $discount,
            'shipping_cost' => $shipping_cost,
            'total' => $total,
        ]);
    }

    public function placeOrder()
    {
        $this->validate([
            'shipping_address_id' => 'required',
            'payment_method' => 'required',
            'agree_terms' => 'accepted',
        ]);

        // 1. Get the Address from DB
        $addr = UserAddress::where('user_id', Auth::id())
            ->findOrFail($this->shipping_address_id);

        // 2. Get Cart Items
        $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();
        // Group items by vendor (Since your Order model has a vendor_id)
        $groupedItems = $cartItems->groupBy(fn($item) => $item->product->vendor_id);

        DB::transaction(function () use ($groupedItems, $addr) {
            foreach ($groupedItems as $vendorId => $items) {

                $subtotal = $items->sum(fn($i) => $i->product->effective_price * $i->quantity);
                $shipping_cost = 15.00; // Flat rate example
                $total = $subtotal + $shipping_cost;

                // 3. Create the Order using DB address fields
                $order = Order::create([
                    'user_id' => Auth::id(),
                    'vendor_id' => $vendorId,
                    'order_status' => OrderStatus::Pending,
                    'payment_status' => PaymentStatus::Pending,

                    // Mapping Shipping Address from DB
                    'shipping_first_name' => $addr->first_name,
                    'shipping_last_name' => $addr->last_name,
                    'shipping_email' => $addr->email,
                    'shipping_phone' => $addr->phone,
                    'shipping_address_line_1' => $addr->address_line_1,
                    'shipping_address_line_2' => $addr->address_line_2,
                    'shipping_city' => $addr->city,
                    'shipping_state' => $addr->state,
                    'shipping_zip_code' => $addr->zip_code,
                    'shipping_country' => $addr->country,

                    // Billing Address (using same address if "Bill to different" is false)
                    'billing_first_name' => $this->bill_to_different_address ? $this->billing['name'] : $addr->first_name,
                    'billing_address_line_1' => $this->bill_to_different_address ? $this->billing['address'] : $addr->address_line_1,
                    // ... map other billing fields similarly ...

                    'subtotal' => $subtotal,
                    'shipping_cost' => $shipping_cost,
                    'total_amount' => $total,
                    'payment_method' => $this->payment_method,
                    'shipping_method' => $this->shipping_method,
                    'notes' => $this->order_notes,
                    'placed_at' => now(),
                ]);

                // 4. Create Order Items
                foreach ($items as $cartItem) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $cartItem->product_id,
                        'product_name' => $cartItem->product->name,
                        'unit_price' => $cartItem->product->effective_price,
                        'quantity' => $cartItem->quantity,
                        'options' => $cartItem->options,
                        'total_price' => $cartItem->product->effective_price * $cartItem->quantity,
                    ]);
                }
            }

            // 5. Clear Cart
            CartItem::where('user_id', Auth::id())->delete();
        });

        $this->dispatch('cartUpdated');
        return redirect()->route('user.checkout.success')->with('message', 'Order placed successfully!');
    }
}
