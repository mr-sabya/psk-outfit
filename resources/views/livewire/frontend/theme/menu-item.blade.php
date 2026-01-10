<ul class="{{ $className }}">
    <li>
        <a class="{{ Route::is('home') ? 'active' : '' }}" href="{{ route('home')}}" wire:navigate>Home</a>
    </li>

    <!-- Professional Category Dropdown -->
    <li class="nav-item-category">
        <a class="category-trigger {{ Route::is('category*') ? 'active' : '' }}" href="{{ route('category')}}" wire:navigate>
            <i class="fas fa-th-large"></i> <!-- FA 5.15.1 Grid Icon -->
            <span>Categories</span>
            <i class="fas fa-chevron-down arrow-icon"></i>
        </a>

        <ul class="professional-dropdown">
            @foreach($categories as $category)
            <li class="cat-item {{ $category->children->count() > 0 ? 'has-children' : '' }}">
                <a href="{{ route('shop', ['category' => $category->slug]) }}" wire:navigate class="cat-link">
                    <span class="cat-info">
                        @if($category->icon_url)
                        <img src="{{ $category->icon_url }}" alt="{{ $category->name }}" class="cat-icon">
                        @else
                        <i class="fas fa-tags default-icon"></i> <!-- FA 5.15.1 Default Icon -->
                        @endif
                        <span class="cat-name">{{ $category->name }}</span>
                    </span>

                    @if($category->children->count() > 0)
                    <i class="fas fa-chevron-right flyout-arrow"></i>
                    @endif
                </a>

                {{-- Subcategory Flyout --}}
                @if($category->children->count() > 0)
                <div class="subcategory-flyout">
                    <h6 class="flyout-title">{{ $category->name }}</h6>
                    <div class="flyout-grid">
                        @foreach($category->children as $child)
                        <a href="{{ route('shop', ['category' => $child->slug]) }}" wire:navigate class="sub-link">
                            <i class="fas fa-minus fa-xs" style="opacity: 0.3; margin-right: 5px;"></i>
                            {{ $child->name }}
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </li>
            @endforeach
        </ul>
    </li>

    <li><a class="{{ Route::is('shop') ? 'active' : '' }}" href="{{ route('shop') }}" wire:navigate>Shop</a></li>
    <li><a class="{{ Route::is('flash-deals') ? 'active' : '' }}" href="{{ route('flash-deals') }}" wire:navigate>Flash Deals</a></li>
    <li><a class="{{ Route::is('blog') ? 'active' : '' }}" href="{{ route('blog') }}" wire:navigate>Blog</a></li>
    <li>
        <a class="{{ Route::is('contact') ? 'active' : '' }}" href="{{ route('contact') }}" wire:navigate>Contact </a>
    </li>
</ul>