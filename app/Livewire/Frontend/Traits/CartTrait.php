<?php

namespace App\Livewire\Frontend\Traits;

use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

trait CartTrait
{
    // Updated signature to include $price and $isCombo
    public function handleAddToCart($productId, $quantity = 1, $options = [], $price = null, $isCombo = false, $mainProductId = null)
    {
        if (!Auth::check()) return $this->redirect(route('login'), navigate: true);

        $normalizedOptions = (!empty($options) && is_array($options)) ? (ksort($options) ? $options : $options) : null;

        // Check if item exists (including combo status and main_product link)
        $existingItem = CartItem::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->where('is_combo', $isCombo)
            ->where('main_product_id', $mainProductId)
            ->where('options', $normalizedOptions)
            ->first();

        if ($existingItem) {
            $existingItem->increment('quantity', $quantity);
        } else {
            CartItem::create([
                'user_id'         => Auth::id(),
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
