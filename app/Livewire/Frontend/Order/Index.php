<?php

namespace App\Livewire\Frontend\Order;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        // Fetch orders for the logged-in user, paginated
        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('livewire.frontend.order.index', [
            'orders' => $orders
        ]);
    }
}
