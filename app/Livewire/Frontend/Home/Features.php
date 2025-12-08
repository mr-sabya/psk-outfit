<?php

namespace App\Livewire\Frontend\Home;

use Livewire\Component;
use App\Models\Feature; // Import the Feature model

class Features extends Component
{
    public function render()
    {
        // Fetch active features, sorted by the order defined in the backend
        $features = Feature::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->take(4)
            ->get();

        return view('livewire.frontend.home.features', [
            'features' => $features
        ]);
    }
}
