<?php

namespace App\Livewire\Frontend\Traits;

use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

trait CartTrait
{
    public function handleAddToCart($productId, $quantity = 1, $options = [], $price = null, $isCombo = false, $mainProductId = null)
    {
        // 1. Determine Identity (User ID or Session ID)
        $userId = Auth::id();
        if (!Session::isStarted()) {
            Session::start();
        }
        $sessionId = Session::getId(); // Unique ID for guest browsers


        $normalizedOptions = (!empty($options) && is_array($options)) ? (ksort($options) ? $options : $options) : null;

        // 2. Find existing item logic
        $query = CartItem::where('product_id', $productId)
            ->where('is_combo', $isCombo)
            ->where('main_product_id', $mainProductId)
            ->where('options', $normalizedOptions);

        // Filter by user if logged in, otherwise by session ID
        if ($userId) {
            $query->where('user_id', $userId);
        } else {
            $query->where('session_id', $sessionId);
        }

        $existingItem = $query->first();

        if ($existingItem) {
            $existingItem->increment('quantity', $quantity);
        } else {
            CartItem::create([
                'user_id'         => $userId,    // Will be null for guests
                'session_id'      => $userId ? null : $sessionId, // Store session for guests
                'product_id'      => $productId,
                'main_product_id' => $mainProductId,
                'quantity'        => $quantity,
                'options'         => $normalizedOptions,
                'price'           => $price,
                'is_combo'        => $isCombo,
            ]);
        }

        $this->dispatch('cartUpdated');
        $this->dispatch('open-cart');
    }
}
