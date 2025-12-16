<?php

namespace App\Livewire\Frontend\Home;

use App\Models\Brand;
use Livewire\Component;

class Brands extends Component
{
    public function render()
    {
        // Fetch active brands, ordered by latest (or name).
        // Limited to 16 to match the grid layout visually.
        $brands = Brand::active()
            ->latest()
            ->take(16)
            ->get();

        return view('livewire.frontend.home.brands', [
            'brands' => $brands
        ]);
    }
}
