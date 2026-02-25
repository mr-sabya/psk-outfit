<?php

namespace App\Livewire\Backend\Components;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\On;

class OrderCountBadge extends Component
{
    public $count = 0;

    public function mount()
    {
        $this->refreshCount();
    }

    // This listener catches the event dispatched from your Index component
    #[On('order-updated')]
    public function refreshCount()
    {
        // Example: Count only pending or new orders for the badge
        $this->count = Order::where('order_status', 'pending')->count();
    }

    public function render()
    {
        return <<<'HTML'
        <span class="badge bg-danger rounded-pill">
            {{ $count > 0 ? $count : '' }}
        </span>
        HTML;
    }
}
