<?php

namespace App\Livewire\Frontend\Theme;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\On;

class CompareIcon extends Component
{
    public $count = 0;

    public function mount()
    {
        $this->updateCount();
    }

    /**
     * Listen for the 'compareUpdated' event dispatched from 
     * the AddToCompare or RemoveFromCompare logic.
     */
    #[On('compareUpdated')]
    public function updateCount()
    {
        $compareList = Session::get('compare', []);
        $this->count = count($compareList);
    }

    public function render()
    {
        return view('livewire.frontend.theme.compare-icon');
    }
}
