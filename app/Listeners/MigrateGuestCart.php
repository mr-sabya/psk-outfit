<?php

namespace App\Listeners;

use App\Models\CartItem;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Session;

class MigrateGuestCart
{
    public function handle(Login $event): void
    {
        $userId = $event->user->id;
        $sessionId = Session::getId();

        // 1. Get all guest items for the current session
        $guestItems = CartItem::where('session_id', $sessionId)
            ->whereNull('user_id')
            ->get();

        foreach ($guestItems as $guestItem) {
            // 2. Check if the logged-in user already has this item in their cart
            $existingUserItem = CartItem::where('user_id', $userId)
                ->where('product_id', $guestItem->product_id)
                ->where('options', $guestItem->options) // Important to check options
                ->where('is_combo', $guestItem->is_combo)
                ->first();

            if ($existingUserItem) {
                // Merge quantity and delete the guest item
                $existingUserItem->increment('quantity', $guestItem->quantity);
                $guestItem->delete();
            } else {
                // Assign guest item to the user
                $guestItem->update([
                    'user_id' => $userId,
                    'session_id' => null,
                ]);
            }
        }
    }
}
