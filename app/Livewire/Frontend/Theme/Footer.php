<?php

namespace App\Livewire\Frontend\Theme;

use App\Models\Category;
use Carbon\Carbon;
use Livewire\Component;

class Footer extends Component
{
    public $currentYear;

    public function mount()
    {
        $this->currentYear = Carbon::now()->year;
    }

    public function render()
    {
        return view('livewire.frontend.theme.footer', [
            'categories' => Category::where('is_active', true)->parentCategories()->take(5)->get(),
        ]);
    }
}
