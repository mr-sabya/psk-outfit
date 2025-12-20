<?php

namespace App\Livewire\Frontend\Theme;

use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;

class WishlistIcon extends Component
{
    /**
     * Listen for the event dispatched from the WishlistTrait
     */
    #[On('wishlistUpdated')]
    public function render()
    {
        $count = 0;

        if (Auth::check()) {
            // Count total items in the wishlist table for this user
            $count = Wishlist::where('user_id', Auth::id())->count();
        }

        return view('livewire.frontend.theme.wishlist-icon', [
            'count' => $count
        ]);
    }
}
