<ul class="menu_cat_item">
    @foreach ($categories as $category)
    <li>
        {{-- Parent Category Link --}}
        <a href="{{ route('shop', ['category' => $category->slug]) }}" wire:navigate>
            <span>
                @if ($category->icon_url)
                <img src="{{ $category->icon_url }}" alt="{{ $category->name }}">
                @else
                {{-- Fallback icon if none exists in DB --}}
                <img src="{{ asset('assets/frontend/images/category_list_icon_1.png') }}" alt="default">
                @endif
            </span>
            {{ $category->name }}
        </a>

        {{-- Level 2: Children --}}
        @if ($category->children->isNotEmpty())
        <ul class="menu_cat_droapdown">
            @foreach ($category->children as $child)
            <li>
                <a href="{{ route('shop', ['category' => $child->slug]) }}" wire:navigate>
                    {{ $child->name }}

                    {{-- Show arrow if this child has grandchildren --}}
                    @if ($child->children->isNotEmpty())
                    <i class="fal fa-angle-right"></i>
                    @endif
                </a>

                {{-- Level 3: Grandchildren --}}
                @if ($child->children->isNotEmpty())
                <ul class="sub_category">
                    @foreach ($child->children as $grandChild)
                    <li>
                        <a href="{{ route('shop', ['category' => $grandChild->slug]) }}" wire:navigate>
                            {{ $grandChild->name }}
                        </a>
                    </li>
                    @endforeach
                </ul>
                @endif
            </li>
            @endforeach
        </ul>
        @endif
    </li>
    @endforeach

    {{-- Static "View All" Link --}}
    <li class="all_category">
        <a href="{{ route('category') }}" wire:navigate>
            View All Categories <i class="far fa-arrow-right"></i>
        </a>
    </li>
</ul>