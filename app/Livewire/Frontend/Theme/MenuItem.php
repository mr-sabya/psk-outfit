<?php

namespace App\Livewire\Frontend\Theme;

use Livewire\Component;

class MenuItem extends Component
{
    public $className = 'menu_item';

    public function mount($className = 'menu_item')
    {
        $this->className = $className;
    }

    public function render()
    {
        return view('livewire.frontend.theme.menu-item');
    }
}
