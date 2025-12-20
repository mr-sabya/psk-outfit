<?php

namespace App\Livewire\Frontend\Home;

use App\Models\BlogPost;
use Livewire\Component;

class Blogs extends Component
{
    public function render()
    {
        // Fetch the 4 most recent published posts
        $posts = BlogPost::published()
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('livewire.frontend.home.blogs', [
            'posts' => $posts
        ]);
    }
}
