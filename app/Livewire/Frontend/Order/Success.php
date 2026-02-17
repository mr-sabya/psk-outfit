<?php

namespace App\Livewire\Frontend\Order;

use Livewire\Component;

class Success extends Component
{
    public $orderNumber;

    public function mount($order_number = null)
    {
        $this->orderNumber = '#' . ltrim($order_number, '#');
        // dd($this->orderNumber);
    }


    public function render()
    {
        return view('livewire.frontend.order.success');
    }
}
