<div class="product_item_2 product_item">
    <div class="product_img">
        {{-- Use the thumbnail_url accessor created in your Product Model --}}
        <img src="{{ $product->thumbnail_url ?? asset('assets/frontend/images/default-product.png') }}"
            alt="{{ $product->name }}"
            class="img-fluid w-100">

        <ul class="discount_list">
            {{-- Check is_new attribute --}}
            @if($product->is_new)
            <li class="new">new</li>
            @endif

            {{-- Optional: Show Discount Percentage if effective price is lower --}}
            @if($product->effective_price < $product->price && $product->price > 0)
                <li class="discount">
                    -{{ round((($product->price - $product->effective_price) / $product->price) * 100) }}%
                </li>
                @endif
        </ul>

        <ul class="btn_list">
            <li>
                <a href="javascript:void(0);" aria-label="Compare">
                    <img src="{{ url('assets/frontend/images/compare_icon_white.svg') }}" alt="Compare" class="img-fluid">
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" aria-label="Add to Wishlist">
                    <img src="{{ url('assets/frontend/images/love_icon_white.svg') }}" alt="Love" class="img-fluid">
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" wire:click="addToCart" aria-label="Add to Cart">
                    <img src="{{ url('assets/frontend/images/cart_icon_white.svg') }}" alt="Cart" class="img-fluid">
                </a>
            </li>
        </ul>
    </div>

    <div class="product_text">
        {{-- Link to details page (Adjust route name 'product.details' as needed) --}}
        <a class="title" href="{{ route('product.show', $product->slug) }}" wire:navigate>
            {{ Str::limit($product->name, 20) }}
        </a>

        <p class="price">
            {{-- Logic to show discounted price --}}
            @if($product->effective_price < $product->price)
                <span class="text-danger">৳{{ number_format($product->effective_price, 2) }}</span>
                <del class="text-muted" style="font-size: 0.9em;">${{ number_format($product->price, 2) }}</del>
                @else
                ৳{{ number_format($product->price, 2) }}
                @endif
        </p>

        <p class="rating mb-0">
            {{-- dynamic star rating calculation based on loaded reviews --}}
            @php
            $avgRating = $product->reviews->avg('rating') ?? 0;
            $fullStars = floor($avgRating);
            $halfStar = $avgRating - $fullStars >= 0.5;
            $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
            @endphp

            @for($i = 0; $i < $fullStars; $i++)
                <i class="fas fa-star text-warning"></i>
                @endfor

                @if($halfStar)
                <i class="fas fa-star-half-alt text-warning"></i>
                @endif

                @for($i = 0; $i < $emptyStars; $i++)
                    <i class="far fa-star text-warning"></i>
                    @endfor

                    <span>({{ $product->reviews->count() }} reviews)</span>
        </p>

    </div>
</div>