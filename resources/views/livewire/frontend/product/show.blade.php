<section class="shop_details mt_100">
    <div class="container">
        {{-- Flash Messages --}}
        @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session()->has('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row">
            <div class="col-xxl-10">
                <div class="row">
                    {{-- Left Side: Image Gallery (Keep existing) --}}
                    <div class="col-lg-6 col-md-10 wow fadeInLeft">
                        <div class="shop_details_slider_area" wire:ignore>
                            <div class="row">
                                <div class="col-xl-2 col-lg-3 col-md-3 order-2 order-md-1">
                                    <div class="row details_slider_nav">
                                        <div class="col-12">
                                            <div class="details_slider_nav_item"><img src="{{ $product->thumbnail_url }}" class="img-fluid w-100"></div>
                                        </div>
                                        @foreach($product->images as $image)
                                        <div class="col-12">
                                            <div class="details_slider_nav_item"><img src="{{ $image->image_url }}" class="img-fluid w-100"></div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-xl-10 col-lg-9 col-md-9 order-md-1">
                                    <div class="row details_slider_thumb">
                                        <div class="col-12">
                                            <div class="details_slider_thumb_item"><img src="{{ $product->thumbnail_url }}" class="img-fluid w-100"></div>
                                        </div>
                                        @foreach($product->images as $image)
                                        <div class="col-12">
                                            <div class="details_slider_thumb_item"><img src="{{ $image->image_url }}" class="img-fluid w-100"></div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right Side: Product Details (Keep existing) --}}
                    <div class="col-lg-6 wow fadeInUp">
                        <div class="shop_details_text">
                            <p class="category">{{ $product->categories->pluck('name')->implode(', ') }}</p>
                            <h2 class="details_title">{{ $product->name }}</h2>

                            <div class="d-flex flex-wrap align-items-center">
                                <p class="stock {{ $product->current_stock > 0 ? '' : 'out_stock' }}">
                                    {{ $product->current_stock > 0 ? 'In Stock ('.$product->current_stock.')' : 'Out of Stock' }}
                                </p>
                                <p class="rating">
                                    @for($i=1; $i<=5; $i++) <i class="{{ $i <= ($product->reviews_avg_rating ?? 0) ? 'fas' : 'far' }} fa-star"></i> @endfor
                                        <span>({{ $product->reviews_count ?? 0 }} reviews)</span>
                                </p>
                            </div>

                            <h3 class="price">
                                ৳{{ number_format($product->effective_price, 2) }}
                                @if($product->compare_at_price > $product->effective_price)
                                <del>৳{{ number_format($product->compare_at_price, 2) }}</del>
                                @endif
                            </h3>

                            <p class="short_description">{{ $product->short_description }}</p>

                            {{-- Attributes --}}
                            @if($product->isVariable() && !empty($groupedAttributes))
                            @foreach($groupedAttributes as $attrId => $group)
                            <div class="details_single_variant">
                                <p class="variant_title">{{ $group['name'] }} :</p>
                                <ul class="{{ (strtolower($group['display_type']?->value ?? $group['display_type']) === 'color') ? 'details_variant_color' : 'details_variant_size' }}">
                                    @foreach($group['values'] as $val)
                                    <li class="{{ (isset($selectedAttributes[$attrId]) && $selectedAttributes[$attrId] == $val->id) ? 'active' : '' }}"
                                        wire:click="selectAttribute({{ $attrId }}, {{ $val->id }})"
                                        style="{{ (strtolower($group['display_type']?->value ?? $group['display_type']) === 'color') ? 'background: '.$val->value : '' }}; cursor: pointer;">
                                        {{ (strtolower($group['display_type']?->value ?? $group['display_type']) !== 'color') ? $val->value : '' }}
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endforeach
                            @endif

                            <div class="d-flex flex-wrap align-items-center">
                                <div class="details_qty_input">
                                    <button class="minus" wire:click="decrementQty"><i class="fal fa-minus"></i></button>
                                    <input type="text" wire:model="quantity" readonly>
                                    <button class="plus" wire:click="incrementQty"><i class="fal fa-plus"></i></button>
                                </div>
                                <div class="details_btn_area">
                                    <a class="common_btn buy_now" href="javascript:void(0)" wire:click="buyNow">Buy Now <i class="fas fa-long-arrow-right"></i></a>
                                    <a class="common_btn" href="javascript:void(0)" wire:click="addToCart">Add to cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- NEW: BUNDLE / COMBO SECTION --}}
                {{-- Find this section in your show.blade.php --}}
                @if($product->bundleProducts->isNotEmpty())
                <div class="row mt_50 wow fadeInUp">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm" style="background: #f9f9f9; border-radius: 15px;">
                            <div class="card-body p-4">
                                <h4 class="mb-4 fw-bold">Combo Offer (Bundle Deal)</h4>
                                <div class="d-flex align-items-center flex-wrap">
                                    {{-- Main Product --}}
                                    <div class="text-center mb-3" style="width: 120px;">
                                        <img src="{{ $product->thumbnail_url }}" class="img-fluid rounded border mb-2" style="height: 80px; width: 80px; object-fit: cover;">
                                        <p class="small mb-0 text-truncate px-2">{{ $product->name }}</p>
                                        <span class="fw-bold small">৳{{ number_format($product->effective_price, 0) }}</span>
                                    </div>

                                    @php $totalBundlePrice = $product->effective_price; @endphp

                                    @foreach($product->bundleProducts as $bundleItem)
                                    <div class="px-3 mb-3 text-muted"><i class="fal fa-plus"></i></div>
                                    <div class="text-center mb-3" style="width: 120px;">
                                        <a href="{{ route('product.show', $bundleItem->slug) }}" target="_blank">
                                            <img src="{{ $bundleItem->thumbnail_url }}" class="img-fluid rounded border mb-2" style="height: 80px; width: 80px; object-fit: cover;">
                                        </a>
                                        <p class="small mb-0 text-truncate px-2">{{ $bundleItem->name }}</p>
                                        <span class="fw-bold small text-primary">৳{{ number_format($bundleItem->pivot->special_price, 0) }}</span>
                                        @php $totalBundlePrice += $bundleItem->pivot->special_price; @endphp
                                    </div>
                                    @endforeach

                                    <div class="ms-md-5 mb-3 border-start ps-md-4">
                                        <p class="mb-1 text-muted">Total Bundle Price:</p>
                                        <h3 class="fw-bold text-danger mb-3">৳{{ number_format($totalBundlePrice, 2) }}</h3>

                                        {{-- UPDATED BUTTON: Buy Bundle Now --}}
                                        <button wire:click="buyBundleNow" class="common_btn btn-danger">
                                            <span wire:loading.remove wire:target="buyBundleNow">
                                                Buy Combo Now <i class="fas fa-bolt ms-2"></i>
                                            </span>
                                            <span wire:loading wire:target="buyBundleNow">
                                                Processing...
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Description Tabs (Keep existing) --}}
                <div class="row mt_90 wow fadeInUp">
                    <div class="col-12">
                        <div class="shop_details_des_area">
                            <ul class="nav nav-pills" id="pills-tab2">
                                <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#description">Description</button></li>
                                <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#description2">Additional info</button></li>
                                <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#vendor">Vendor</button></li>
                                <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#reviews">Reviews</button></li>
                            </ul>

                            <div class="tab-content" id="pills-tabContent2">
                                <div class="tab-pane fade show active" id="description">{!! $product->long_description !!}</div>
                                <div class="tab-pane fade" id="description2">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <tbody>
                                                @php $groupedSpecs = $product->specifications->groupBy(fn($spec) => $spec->key->group ?? 'General'); @endphp
                                                @forelse($groupedSpecs as $groupName => $specs)
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
                                                    <td colspan="2" class="text-center text-muted">No specifications.</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="vendor">
                                    @if($product->vendor)
                                    <div class="shop_details_vendor">
                                        <div class="shop_details_vendor_logo_area">
                                            <div class="img"><img src="{{ $product->vendor->profile_photo_url ?? asset('assets/images/default_user.png') }}" class="img-fluid"></div>
                                            <h3>{{ $product->vendor->name }}</h3>
                                        </div>
                                        <ul class="shop_details_vendor_address">
                                            <li><span>Email:</span> {{ $product->vendor->email }}</li>
                                        </ul>
                                    </div>
                                    @endif
                                </div>
                                <div class="tab-pane fade" id="reviews">
                                    <livewire:frontend.product.review :product="$product" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-2 wow fadeInRight">
                <livewire:frontend.product.sidebar :product="$product" />
            </div>
        </div>
    </div>
</section>