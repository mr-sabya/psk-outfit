<?php

namespace App\Livewire\Frontend\Coupon;

use App\Models\Coupon;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public function render()
    {
        $query = Coupon::active();

        if (Auth::check()) {
            // Logged in: Show Public Coupons OR Coupons assigned specifically to THIS user
            $query->where(function ($q) {
                $q->whereDoesntHave('users') 
                  ->orWhereHas('users', function ($sq) {
                      $sq->where('users.id', Auth::id());
                  });
            });
        } else {
            // Guest: Show only Public Coupons
            $query->whereDoesntHave('users');
        }

        $coupons = $query->latest()->get();

        return view('livewire.frontend.coupon.index', [
            'coupons' => $coupons
        ]);
    }
}
