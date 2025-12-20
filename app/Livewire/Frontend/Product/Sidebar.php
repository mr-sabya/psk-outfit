<?php

namespace App\Livewire\Frontend\Product;

use Livewire\Component;

class Sidebar extends Component
{
    public $product;

    public function mount($product)
    {
        $this->product = $product;
    }
    
    public function render()
    {
        return view('livewire.frontend.product.sidebar');
    }
}
