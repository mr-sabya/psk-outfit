<?php

namespace App\Livewire\Frontend\Components;

use Livewire\Component;

class PageBanner extends Component
{
    public $title;

    public function mount($title)
    {
        $this->title = $title;
    }
    
    public function render()
    {
        return view('livewire.frontend.components.page-banner');
    }
}
