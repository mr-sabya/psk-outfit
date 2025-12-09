<?php

namespace App\Livewire\Frontend\Home;

use Livewire\Component;
use App\Models\Deal; // Assuming you have this model based on your Product relation
use Illuminate\Database\Eloquent\Builder;

class FlashSale extends Component
{
    public $deal = null;
    public $readyToLoad = false;

    public function mount()
    {
        // Find the first active deal that ends in the future
        $this->deal = Deal::where('is_active', true)
            ->where('expires_at', '>', now())
            ->with(['products' => function ($query) {
                $query->active()
                    ->with(['reviews', 'variants.attributeValues'])
                    ->take(10);
            }])
            ->orderBy('expires_at', 'asc') // Get the one ending soonest
            ->first();
    }

    public function render()
    {
        return view('livewire.frontend.home.flash-sale');
    }
}
