<?php

namespace App\Livewire\Frontend\Theme;

use Livewire\Component;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\On;

class CartIcon extends Component
{
    /**
     * Listen for the 'cartUpdated' event to refresh the count
     */
    #[On('cartUpdated')]
    public function render()
    {
        // 1. Initialize query
        $query = CartItem::query();

        // 2. Filter based on Auth or Session
        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', Session::getId());
        }

        // 3. Get the count
        // Note: use ->count() for unique items or ->sum('quantity') for total items
        $count = $query->count();

        return view('livewire.frontend.theme.cart-icon', [
            'count' => $count
        ]);
    }
}
