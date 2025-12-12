<section class="category category_2 mt_55">
    <div class="container">
        {{--
           If 'category_2_slider' initializes a JS plugin (like Slick/Owl), 
           Livewire renders might conflict if data updates dynamically.
           Since this is usually static on load, it should work fine.
        --}}
        <div class="row category_2_slider">

            @forelse ($categories as $category)
            <div class="col-2 wow fadeInUp" wire:key="category-{{ $category->id }}">
                {{-- Update href to your actual shop route, passing the slug --}}
                <livewire:frontend.components.category :category="$category" />
            </div>
            @empty
            <div class="col-12 text-center">
                <p>No categories found.</p>
            </div>
            @endforelse

        </div>
    </div>
</section>