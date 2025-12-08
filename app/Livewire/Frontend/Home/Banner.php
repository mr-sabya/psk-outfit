<?php

namespace App\Livewire\Frontend\Home;

use Livewire\Component;
use App\Models\Banner as BannerModel; // Alias to avoid conflict with class name

class Banner extends Component
{
    public function render()
    {
        // Fetch active banners sorted by order
        $banners = BannerModel::where('is_active', true)
            ->orderBy('order', 'asc')
            ->get();

        return view('livewire.frontend.home.banner', [
            'banners' => $banners
        ]);
    }
}
