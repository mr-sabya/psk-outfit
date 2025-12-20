<?php

namespace App\Livewire\Frontend\Blog;

use App\Models\BlogPost;
use Livewire\Component;

class Show extends Component
{
    public BlogPost $post;

    public function mount($blogId)
    {
        // We find the post by slug and ensure it is published
        $this->post = BlogPost::published()
            ->with(['category', 'tags']) // Eager load relations
            ->where('id', $blogId)
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.frontend.blog.show');
    }
}
