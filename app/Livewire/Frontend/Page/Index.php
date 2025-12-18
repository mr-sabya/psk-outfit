<?php

namespace App\Livewire\Frontend\Page;

use Livewire\Component;
use App\Models\Page;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    public $page;

    /**
     * Mounts the component.
     * 
     * @param string $pageId The ID of the page passed from the Route (e.g., /p/about-us)
     */
    public function mount($pageId)
    {
        // 1. Fetch the page by ID
        // 2. Ensure it is marked as 'active'
        // 3. Fail (404) if not found
        $this->page = Page::where('id', $pageId)
            ->active()
            ->firstOrFail();

        // Optional: Increment view count here if you have that field
    }

    public function render()
    {
        // Pass the SEO metadata to the main layout
        return view('livewire.frontend.page.index');
    }
}