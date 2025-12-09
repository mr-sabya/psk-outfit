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
                <a href="javascript:void(0);" aria-label="Add to Cart">
                    <img src="{{ url('assets/frontend/images/cart_icon_white.svg') }}" alt="Cart" class="img-fluid">
                </a>
            </li>
        </ul>
    </div>

    <div class="product_text">
        {{-- Link to details page (Adjust route name 'product.details' as needed) --}}
        <a class="title" href="#">
            {{ $product->name }}
        </a>

        <p class="price">
            {{-- Logic to show discounted price --}}
            @if($product->effective_price < $product->price)
                <span class="text-danger">${{ number_format($product->effective_price, 2) }}</span>
                <del class="text-muted" style="font-size: 0.9em;">${{ number_format($product->price, 2) }}</del>
                @else
                ${{ number_format($product->price, 2) }}
                @endif
        </p>

        <p class="rating">
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

        {{--
            Color Logic: 
            This attempts to find unique colors from the variants.
            It assumes your AttributeValue has a 'value' that is a hex code or name.
            If your data structure is different, you might need to adjust the pluck key.
        --}}
        @if($isColor && $product->isVariable())
        @php
        // Get unique attribute values from all variants (assuming specific naming)
        // You might need to filter by Attribute name = 'Color' if you have the Attribute model
        $colors = $product->variants
        ->flatMap(fn($v) => $v->attributeValues)
        ->unique('id')
        ->take(4); // Limit to 4 circles
        @endphp

        @if($colors->isNotEmpty())
        <ul class="color">
            @foreach($colors as $color)
            {{-- Assuming 'value' contains the hex code or color name --}}
            <li style="background: {{ $color->value }}" title="{{ $color->value }}"></li>
            @endforeach
        </ul>
        @endif
        @endif
    </div>
</div>