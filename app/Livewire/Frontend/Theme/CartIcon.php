<?php

namespace App\Livewire\Frontend\Theme;

use Livewire\Component;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class CartIcon extends Component
{
    /**
     * Listen for the 'cartUpdated' event to refresh the count
     */
    #[On('cartUpdated')]
    public function render()
    {
        $count = 0;

        if (Auth::check()) {
            // Count total items in the database for this user
            $count = CartItem::where('user_id', Auth::id())->count();
        }

        return view('livewire.frontend.theme.cart-icon', [
            'count' => $count
        ]);
    }
}
