<?php

namespace App\Livewire\Frontend\Order;

use App\Models\Order;
use Livewire\Component;

class Track extends Component
{
    public $orderNumber;
    public $order;
    public $notFound = false;

    // Optional: Auto-fill if Order ID is passed via URL
    public function mount($order_number = null)
    {
        if ($order_number) {
            // 1. Add the # back so it matches your database format (e.g. #RVXELCLGS8)
            $this->orderNumber = '#' . ltrim($order_number, '#');

            // 2. Automatically trigger the search/track logic
            $this->trackOrder();
        }
    }

    public function trackOrder()
    {
        $this->validate([
            'orderNumber' => 'required|string|min:5'
        ]);

        // Clean the input (remove spaces or hashtags if user typed them)
        $searchId = trim($this->orderNumber);

        $this->order = Order::with(['orderItems.product', 'shippingMethod', 'paymentMethod'])
            ->where('order_number', $searchId)
            // If you want to restrict tracking to logged-in users only:
            // ->where('user_id', auth()->id()) 
            ->first();

        if (!$this->order) {
            $this->notFound = true;
            $this->order = null;
        } else {
            $this->notFound = false;
        }
    }

    public function render()
    {
        return view('livewire.frontend.order.track');
    }
}
