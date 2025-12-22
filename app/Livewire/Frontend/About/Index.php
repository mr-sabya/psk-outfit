<?php

namespace App\Livewire\Frontend\About;

use Livewire\Component;
use App\Models\About;
use App\Models\WhyChoose;
use App\Models\Counter;

class Index extends Component
{
    public $about;
    public $whyChoose;
    public $counter;

    public function mount()
    {
        // Fetch data from the database
        $this->about = About::first();
        $this->whyChoose = WhyChoose::first();
        $this->counter = Counter::first();
    }

    public function render()
    {
        return view('livewire.frontend.about.index');
    }
}
