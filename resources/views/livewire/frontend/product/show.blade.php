<section class="shop_details mt_100">
    <div class="container">
        <div class="row">
            <div class="col-xxl-10">
                <div class="row">
                    {{-- Left Side: Image Gallery --}}
                    <div class="col-lg-6 col-md-10 wow fadeInLeft">
                        <div class="shop_details_slider_area" wire:ignore>
                            <div class="row">
                                {{-- Thumbnail Slider --}}
                                <div class="col-xl-2 col-lg-3 col-md-3 order-2 order-md-1">
                                    <div class="row details_slider_nav">
                                        <div class="col-12">
                                            <div class="details_slider_nav_item">
                                                <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}" class="img-fluid w-100">
                                            </div>
                                        </div>
                                        @foreach($product->images as $image)
                                        <div class="col-12">
                                            <div class="details_slider_nav_item">
                                                <img src="{{ $image->image_url }}" alt="{{ $product->name }}" class="img-fluid w-100">
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                {{-- Main Image Slider --}}
                                <div class="col-xl-10 col-lg-9 col-md-9 order-md-1">
                                    <div class="row details_slider_thumb">
                                        <div class="col-12">
                                            <div class="details_slider_thumb_item">
                                                <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}" class="img-fluid w-100">
                                            </div>
                                        </div>
                                        @foreach($product->images as $image)
                                        <div class="col-12">
                                            <div class="details_slider_thumb_item">
                                                <img src="{{ $image->image_url }}" alt="{{ $product->name }}" class="img-fluid w-100">
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right Side: Product Details --}}
                    <div class="col-lg-6 wow fadeInUp">
                        <div class="shop_details_text">
                            {{-- Categories --}}
                            <p class="category">
                                {{ $product->categories->pluck('name')->implode(', ') }}
                            </p>

                            <h2 class="details_title">{{ $product->name }}</h2>

                            <div class="d-flex flex-wrap align-items-center">
                                @if($product->current_stock > 0)
                                <p class="stock">In Stock ({{ $product->current_stock }})</p>
                                @else
                                <p class="out_stock stock">Out of Stock</p>
                                @endif

                                <p class="rating">
                                    @php
                                    $avgRating = $product->reviews_avg_rating ?? 0;
                                    $reviewCount = $product->reviews_count ?? 0;
                                    @endphp
                                    @for($i=1; $i<=5; $i++)
                                        <i class="{{ $i <= $avgRating ? 'fas' : 'far' }} fa-star"></i>
                                        @endfor
                                        <span>({{ $reviewCount }} reviews)</span>
                                </p>
                            </div>

                            <h3 class="price">
                                ৳{{ number_format($product->effective_price, 2) }}
                                @if($product->compare_at_price > $product->effective_price)
                                <del>৳{{ number_format($product->compare_at_price, 2) }}</del>
                                @endif
                            </h3>

                            <p class="short_description">{{ $product->short_description }}</p>

                            {{-- ATTRIBUTE SELECTION LOOP --}}
                            @if($product->isVariable() && !empty($groupedAttributes))
                            @foreach($groupedAttributes as $attrId => $group)
                            <div class="details_single_variant">
                                <p class="variant_title">{{ $group['name'] }} :</p>

                                {{-- COLOR ATTRIBUTES --}}
                                @if(strtolower($group['display_type']?->value ?? $group['display_type']) === 'color' || strtolower($group['name']) === 'color')
                                <ul class="details_variant_color">
                                    @foreach($group['values'] as $val)
                                    @php
                                    // Check if this specific value is selected
                                    $isSelected = isset($selectedAttributes[$attrId]) && $selectedAttributes[$attrId] == $val->id;
                                    @endphp
                                    <li
                                        class="{{ $isSelected ? 'active' : '' }}"
                                        wire:click="selectAttribute({{ $attrId }}, {{ $val->id }})"
                                        style="background: {{ $val->value }}; cursor: pointer;">
                                    </li>
                                    @endforeach
                                </ul>

                                {{-- TEXT/SIZE ATTRIBUTES --}}
                                @else
                                <ul class="details_variant_size">
                                    @foreach($group['values'] as $val)
                                    @php
                                    $isSelected = isset($selectedAttributes[$attrId]) && $selectedAttributes[$attrId] == $val->id;
                                    @endphp
                                    <li
                                        class="{{ $isSelected ? 'active' : '' }}"
                                        wire:click="selectAttribute({{ $attrId }}, {{ $val->id }})"
                                        style="cursor: pointer;">
                                        {{ $val->value }}
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                            @endforeach
                            @endif
                            {{-- END ATTRIBUTES --}}

                            <div class="d-flex flex-wrap align-items-center">
                                <div class="details_qty_input">
                                    <button class="minus" wire:click="decrementQty"><i class="fal fa-minus"></i></button>
                                    <input type="text" wire:model="quantity" readonly>
                                    <button class="plus" wire:click="incrementQty"><i class="fal fa-plus"></i></button>
                                </div>
                                <div class="details_btn_area">
                                    <a class="common_btn buy_now" href="javascript:void(0)" wire:click="buyNow">
                                        <span wire:loading.remove wire:target="buyNow" class="text-white">Buy Now <i class="fas fa-long-arrow-right"></i></span>
                                        <span wire:loading wire:target="buyNow" class="text-white">Processing...</span>
                                    </a>
                                    <a class="common_btn" href="javascript:void(0)" wire:click="addToCart">
                                        Add to cart <i class="fas fa-long-arrow-right"></i>
                                    </a>
                                </div>
                            </div>

                            <ul class="details_list_btn">
                                <li>
                                    <a href="javascript:void(0)"
                                        wire:click="toggleWishlist({{ $product->id }})"
                                        class="{{ $this->isInWishlist($product->id) ? 'text-danger' : '' }}">
                                        <i class="{{ $this->isInWishlist($product->id) ? 'fas fa-heart' : 'fal fa-heart' }}"></i>
                                        {{ $this->isInWishlist($product->id) ? 'Saved to Wishlist' : 'Add to Wishlist' }}
                                    </a>
                                </li>
                                <li><a href="javascript:void(0)" wire:click="addToCompare({{ $product->id }})"><i class="fal fa-exchange"></i> Compare</a></li>
                            </ul>

                            <ul class="details_tags_sku">
                                <li><span>SKU:</span> {{ $product->sku }}</li>
                                <li><span>Category:</span> {{ $product->categories->pluck('name')->implode(', ') }}</li>
                                <li><span>Tag:</span> {{ $product->tags->pluck('name')->implode(', ') }}</li>
                            </ul>

                            {{-- Social Share --}}
                            <ul class="shop_details_shate">
                                <li>Share:</li>
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-pinterest-p"></i></a></li>
                                <li><a href="#"><i class="fab fa-whatsapp"></i></a></li>
                            </ul>

                        </div>
                    </div>
                </div>

                {{-- Description Tabs --}}
                <div class="row mt_90 wow fadeInUp">
                    <div class="col-12">
                        <div class="shop_details_des_area">
                            <ul class="nav nav-pills" id="pills-tab2" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="description-tab" data-bs-toggle="pill"
                                        data-bs-target="#description" type="button">Description</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="description-tab2" data-bs-toggle="pill"
                                        data-bs-target="#description2" type="button" role="tab"
                                        aria-controls="description2" aria-selected="false">Additional info</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="vendor-tab" data-bs-toggle="pill"
                                        data-bs-target="#vendor" type="button">Vendor</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="reviews-tab" data-bs-toggle="pill"
                                        data-bs-target="#reviews" type="button">Reviews</button>
                                </li>
                            </ul>

                            <div class="tab-content" id="pills-tabContent2">
                                {{-- Long Description --}}
                                <div class="tab-pane fade show active" id="description" role="tabpanel">
                                    <div class="shop_details_description">
                                        {!! $product->long_description !!}
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="description2" role="tabpanel" aria-labelledby="description-tab2" tabindex="0">
                                    <div class="shop_details_additional_info">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <tbody>
                                                    @php
                                                    // Group specifications by their group name (e.g., "Dimensions", "Build")
                                                    $groupedSpecs = $product->specifications->groupBy(function($spec) {
                                                    return $spec->key->group ?? 'General';
                                                    });
                                                    @endphp

                                                    @forelse($groupedSpecs as $groupName => $specs)
                                                    {{-- Optional: Add a heading row for each group --}}
                                                    <tr class="table-dark">
                                                        <th colspan="2" class="text-uppercase small fw-bold text-white">{{ $groupName }}</th>
                                                    </tr>

                                                    @foreach($specs as $spec)
                                                    <tr>
                                                        <th width="40%">{{ $spec->key->name }}</th>
                                                        <td>{{ $spec->value }}</td>
                                                    </tr>
                                                    @endforeach
                                                    @empty
                                                    <tr>
                                                        <td colspan="2" class="text-center text-muted">No additional specifications available for this product.</td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                {{-- Vendor Info --}}
                                <div class="tab-pane fade" id="vendor" role="tabpanel">
                                    @if($product->vendor)
                                    <div class="shop_details_vendor">
                                        <div class="shop_details_vendor_logo_area">
                                            <div class="img">
                                                {{-- Assuming User/Vendor has an image/avatar --}}
                                                <img src="{{ $product->vendor->profile_photo_url ?? asset('assets/images/default_user.png') }}" alt="Vendor" class="img-fluid">
                                            </div>
                                            <h3>{{ $product->vendor->name }}</h3>
                                        </div>
                                        <ul class="shop_details_vendor_address">
                                            <li><span>Email:</span> {{ $product->vendor->email }}</li>
                                        </ul>
                                    </div>
                                    @endif
                                </div>

                                {{-- Reviews --}}
                                <div class="tab-pane fade" id="reviews" role="tabpanel">
                                    <livewire:frontend.product.review :product="$product" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar (Vendor Info Repeated or Other Widgets) --}}
            <div class="col-xxl-2 wow fadeInRight">
                <livewire:frontend.product.sidebar :product="$product" />
            </div>
        </div>
    </div>
</section>