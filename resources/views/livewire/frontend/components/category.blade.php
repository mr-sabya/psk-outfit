<a href="{{ route('shop', ['category' => $category->slug]) }}" class="category_item" wire:navigate>
    <div class="img">
        {{-- Use the image_url accessor from the Model --}}
        @if($category->image_url)
        <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="img-fluid w-100">
        @else
        {{-- Fallback placeholder --}}
        <img src="{{ asset('assets/frontend/images/no-image.png') }}" alt="Default" class="img-fluid w-100">
        @endif
    </div>
    <h3>{{ $category->name }}</h3>
</a>