<?php

namespace App\Livewire\Frontend\Blog;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use Livewire\Component;

class Sidebar extends Component
{

    public function render()
    {
        // 2. Fetch Popular Blogs (e.g., latest 3)
        $popularPosts = BlogPost::published()
            ->latest('published_at')
            ->take(3)
            ->get();

        // 3. Fetch Categories with Post Count
        $categories = BlogCategory::withCount(['blogPosts' => function ($query) {
            $query->where('is_published', true)
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now());
        }])->get();

        // 4. Fetch Tags
        $tags = BlogTag::all();

        return view('livewire.frontend.blog.sidebar', [
            'popularPosts' => $popularPosts,
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }
}
