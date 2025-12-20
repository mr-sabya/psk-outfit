<?php

namespace App\Livewire\Frontend\Blog;

use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    // Reset pagination when search changes
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // 1. Fetch Paginated Posts
        $posts = BlogPost::published()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('excerpt', 'like', '%' . $this->search . '%');
            })
            ->latest('published_at')
            ->paginate(12);

        

        return view('livewire.frontend.blog.index', [
            'posts' => $posts,
            
        ]);
    }
}
