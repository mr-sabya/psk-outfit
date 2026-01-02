<?php

namespace App\Livewire\Frontend\Traits;

use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

trait CartTrait
{
    public function handleAddToCart($productId, $quantity = 1, $options = [])
    {
        if (!Auth::check()) {
            // Manually store the current URL as the 'intended' destination

            return $this->redirect(route('login'), navigate: true);
        }

        // 1. Normalize Options
        // Ensure $options is an array and sort it.
        // If it's empty, we'll set it to null for consistent DB matching.
        $normalizedOptions = null;
        if (!empty($options) && is_array($options)) {
            ksort($options);
            $normalizedOptions = $options;
        }

        // 2. Build Query
        $query = CartItem::where('user_id', Auth::id())
            ->where('product_id', $productId);

        // 3. Handle the "Empty Options" check explicitly
        if ($normalizedOptions === null) {
            // Check for both NULL and empty JSON array '[]' to be safe
            $query->where(function ($q) {
                $q->whereNull('options')
                    ->orWhere('options', '[]');
            });
        } else {
            // Match the specific JSON content
            $query->where('options', $normalizedOptions);
        }

        $existingItem = $query->first();

        if ($existingItem) {
            $existingItem->increment('quantity', $quantity);
        } else {
            CartItem::create([
                'user_id'    => Auth::id(),
                'product_id' => $productId,
                'quantity'   => $quantity,
                'options'    => $normalizedOptions, // Stored as null or array
            ]);
        }

        
        $this->dispatch('cartUpdated');
        
        // Dispatch browser event to OPEN the offcanvas
        $this->dispatch('open-cart');
    }
}
