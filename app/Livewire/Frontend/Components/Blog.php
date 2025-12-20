<?php

namespace App\Livewire\Frontend\Components;

use App\Models\BlogPost;
use Livewire\Component;

class Blog extends Component
{
    public BlogPost $post; // Define the model property

    public function mount(BlogPost $post)
    {
        $this->post = $post;
    }

    public function render()
    {
        return view('livewire.frontend.components.blog');
    }
}
