<?php

namespace App\Livewire\Backend\AdBanner;

use App\Models\AdBanner;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;

    public $banners = [];
    public $new_images = [];

    public function mount()
    {
        $slots = ['home-banner-1', 'home-banner-2', 'home-banner-3'];

        foreach ($slots as $slot) {
            $banner = AdBanner::firstOrCreate(['slug' => $slot], [
                'title' => 'Default Promo',
                'banner_text' => 'Limited time offer!', // Default value for the new column
                'image_path' => 'banners/default.jpg',
                'link' => '#',
                'is_active' => true
            ]);

            $this->banners[$slot] = $banner->toArray();
        }
    }

    public function save($slug)
    {
        $banner = AdBanner::where('slug', $slug)->first();

        if (isset($this->new_images[$slug])) {
            if ($banner->image_path !== 'banners/default.jpg' && Storage::disk('public')->exists($banner->image_path)) {
                Storage::disk('public')->delete($banner->image_path);
            }

            $path = $this->new_images[$slug]->store('banners', 'public');
            $banner->image_path = $path;
        }

        $banner->update([
            'title' => $this->banners[$slug]['title'],
            'banner_text' => $this->banners[$slug]['banner_text'], // Updated
            'link' => $this->banners[$slug]['link'],
            'is_active' => $this->banners[$slug]['is_active'],
        ]);

        $this->new_images = [];
        session()->flash('success', "Banner " . str_replace('-', ' ', $slug) . " updated successfully!");
    }

    public function render()
    {
        return view('livewire.backend.ad-banner.index');
    }
}
