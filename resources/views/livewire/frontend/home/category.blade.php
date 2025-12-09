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
                <a href="#" class="category_item">
                    <div class="img">
                        {{-- Use the accessor created in the Model for the image URL --}}
                        @if($category->image_url)
                        <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="img-fluid w-100">
                        @else
                        {{-- Fallback placeholder if no image exists --}}
                        <img src="{{ asset('assets/frontend/images/nno-image.jpg') }}" alt="Default" class="img-fluid w-100">
                        @endif
                    </div>
                    <h3>{{ $category->name }}</h3>
                </a>
            </div>
            @empty
            <div class="col-12 text-center">
                <p>No categories found.</p>
            </div>
            @endforelse

        </div>
    </div>
</section>