<?php

namespace App\Livewire\Frontend\User;

use App\Models\Order;
use App\Models\Review;
use App\Models\Wishlist; // Assuming you have a Wishlist model
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public function render()
    {
        $userId = Auth::id();

        // Stats
        $totalOrders = Order::where('user_id', $userId)->count();
        $completedOrders = Order::where('user_id', $userId)->where('order_status', 'delivered')->count();
        $pendingOrders = Order::where('user_id', $userId)->where('order_status', 'pending')->count();
        $canceledOrders = Order::where('user_id', $userId)->where('order_status', 'canceled')->count();
        $wishlistCount = Wishlist::where('user_id', $userId)->count();
        $reviewCount = Review::where('user_id', $userId)->count();

        // Recent Data
        $recentOrders = Order::where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        $recentReviews = Review::with('product')
            ->where('user_id', $userId)
            ->latest()
            ->take(3)
            ->get();

        return view('livewire.frontend.user.dashboard', [
            'totalOrders' => $totalOrders,
            'completedOrders' => $completedOrders,
            'pendingOrders' => $pendingOrders,
            'canceledOrders' => $canceledOrders,
            'wishlistCount' => $wishlistCount,
            'reviewCount' => $reviewCount,
            'recentOrders' => $recentOrders,
            'recentReviews' => $recentReviews,
        ]);
    }
}
