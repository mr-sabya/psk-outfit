<?php

namespace App\Livewire\Frontend\Order;

use App\Models\Order;
use App\Enums\OrderStatus;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use WithPagination;

    // For Cancellation Modal
    public $showCancelModal = false;
    public $selectedOrderId;
    public $cancelReason;

    protected $rules = [
        'cancelReason' => 'required|string|min:10|max:500',
    ];

    /**
     * Open the modal and set the order ID
     */
    public function openCancelModal($orderId)
    {
        $this->selectedOrderId = $orderId;
        $this->showCancelModal = true;
    }

    /**
     * Close modal and reset fields
     */
    public function closeCancelModal()
    {
        $this->showCancelModal = false;
        $this->reset(['selectedOrderId', 'cancelReason']);
    }

    /**
     * Process the actual cancellation
     */
    public function confirmCancel()
    {
        $this->validate();

        $order = Order::where('user_id', Auth::id())
            ->where('order_status', OrderStatus::Pending) // Security check
            ->findOrFail($this->selectedOrderId);

        DB::transaction(function () use ($order) {
            // 1. Update Order Status and Metadata
            $order->update([
                'order_status'  => OrderStatus::Cancelled,
                'cancel_reason' => $this->cancelReason,
                'cancelled_at'  => now(),
                'cancelled_by'  => Auth::id(),
            ]);

            // 2. Restore Stock
            foreach ($order->orderItems as $item) {
                if ($item->product) {
                    $item->product->increment('current_stock', $item->qty);
                }
            }
        });

        $this->closeCancelModal();
        session()->flash('success', 'Order #' . $order->order_number . ' cancelled successfully.');
    }

    public function render()
    {
        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('livewire.frontend.order.index', [
            'orders' => $orders
        ]);
    }
}
