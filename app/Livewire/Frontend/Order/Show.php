<?php

namespace App\Livewire\Frontend\Order;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Show extends Component
{
     public $order;

    public function mount($id)
    {
        // Fetch the order with all necessary relationships
        // We ensure the order belongs to the authenticated user for security
        $this->order = Order::with([
            'orderItems.product', // To show product images/links
            'orderItems.productVariant',
            'shippingCountry', 
            'shippingState', 
            'shippingCity',
            'paymentMethod',
            'shippingMethod'
        ])
        ->where('user_id', Auth::id())
        ->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.frontend.order.show');
    }
}
