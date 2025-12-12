<section class="shop_page mt_100 mb_100">
    <div class="container">
        <div class="row">

            <!-- SIDEBAR START -->
            <div class="col-xxl-2 col-lg-4 col-xl-3">
                <div id="sticky_sidebar">
                    <div class="shop_filter_btn d-lg-none"> Filter </div>
                    <div class="shop_filter_area">

                        <!-- NEW: Reset Filter Button -->
                        <div class="mb-4">
                            <button wire:click="resetFilters"
                                class="common_btn w-100 py-2"
                                style="font-size: 14px; text-transform: uppercase;">
                                <i class="fas fa-undo me-2"></i> Reset All Filters
                            </button>
                        </div>

                        <!-- Price Range -->
                        <div class="sidebar_range" wire:ignore>
                            <h3>Price Range</h3>
                            <div class="range_slider"></div>
                            <div class="d-flex justify-content-between mt-2">
                                <span id="min_price_display">${{ $minPrice }}</span>
                                <span id="max_price_display">${{ $maxPrice }}</span>
                            </div>
                            <!-- Hidden inputs to sync JS slider with Livewire -->
                            <input type="hidden" id="minPriceInput" wire:model.live.debounce.500ms="minPrice">
                            <input type="hidden" id="maxPriceInput" wire:model.live.debounce.500ms="maxPrice">
                        </div>

                        <!-- Product Status -->
                        <div class="sidebar_status">
                            <h3>Product Status</h3>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="onSaleCheck" wire:model.live="isOnSale">
                                <label class="form-check-label" for="onSaleCheck">
                                    On sale
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inStockCheck" wire:model.live="isInStock">
                                <label class="form-check-label" for="inStockCheck">
                                    In Stock
                                </label>
                            </div>
                        </div>

                        <!-- Categories -->
                        <div class="sidebar_category">
                            <h3>Categories</h3>
                            <ul>
                                {{-- Loop through categories loaded in mount --}}
                                @foreach($categories as $category)
                                <li>
                                    <a href="javascript:void(0)"
                                        wire:click="$set('selectedCategory', '{{ $category->slug }}')"
                                        class="{{ $selectedCategory == $category->slug ? 'active text-primary fw-bold' : '' }}">
                                        {{ $category->name }}
                                        <span>{{ $category->products_count }}</span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        @if($colors->isNotEmpty())
                        <div class="sidebar_color">
                            <h3>Filter by Color</h3>
                            <ul>
                                @foreach($colors as $color)
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            value="{{ $color->id }}"
                                            id="color_{{ $color->id }}"
                                            wire:model.live="selectedColors"
                                            style="background-color: {{ $color->value }};">
                                        <label class="form-check-label" for="color_{{ $color->id }}">
                                            {{ $color->value }}
                                        </label>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <!-- NEW: Sizes Section -->
                        @if($sizes->isNotEmpty())
                        <div class="sidebar_size mt-4"> <!-- Add custom class or style if needed -->
                            <h3>Filter by Size</h3>
                            <div class="sidebar_status"> <!-- Reusing existing class for checkbox style -->
                                @foreach($sizes as $size)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        value="{{ $size->id }}"
                                        id="size_{{ $size->id }}"
                                        wire:model.live="selectedSizes">
                                    <label class="form-check-label" for="size_{{ $size->id }}">
                                        {{ $size->value }} {{-- e.g., XL, L, M --}}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Rating -->
                        <div class="sidebar_rating">
                            <h3>Rating</h3>
                            @foreach([5, 4, 3, 2, 1] as $star)
                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                    name="ratingFilter"
                                    id="rating_{{ $star }}"
                                    value="{{ $star }}"
                                    wire:model.live="selectedRating">
                                <label class="form-check-label" for="rating_{{ $star }}">
                                    <i class="fas fa-star text-warning"></i>
                                    {{ $star }} star {{ $star < 5 ? 'or above' : '' }}
                                </label>
                            </div>
                            @endforeach
                        </div>

                        <!-- Top Rated Products -->
                        <div class="sidebar_related_product">
                            <h3>Top Rated Products</h3>
                            <ul>
                                @foreach($topRatedProducts as $topProduct)
                                <li>
                                    <a href="#" class="img">
                                        <img src="{{ $topProduct->thumbnail_url }}" alt="{{ $topProduct->name }}" class="img-fluid">
                                    </a>
                                    <div class="text">
                                        <p class="rating">
                                            @php $rating = round($topProduct->reviews_avg_rating ?? 0); @endphp
                                            @for($i=1; $i<=5; $i++)
                                                <i class="{{ $i <= $rating ? 'fas' : 'far' }} fa-star"></i>
                                                @endfor
                                                <span>({{ $topProduct->reviews_count ?? 0 }})</span>
                                        </p>
                                        <a class="title" href="#">
                                            {{ Str::limit($topProduct->name, 20) }}
                                        </a>
                                        <p class="price">${{ number_format($topProduct->price, 2) }}</p>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
            <!-- SIDEBAR END -->

            <!-- MAIN SHOP AREA START -->
            <div class="col-xxl-10 col-lg-8 col-xl-9">
                <div class="product_page_top">
                    <div class="row">
                        <div class="col-4 col-xl-6 col-md-6">
                            <div class="product_page_top_button">
                                <p>Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }} results</p>
                            </div>
                        </div>
                        <div class="col-8 col-xl-6 col-md-6">
                            <ul class="product_page_sorting">
                                <li>
                                    <select class="form-select" wire:model.live="sortBy">
                                        <option value="default">Default Sorting</option>
                                        <option value="low_high">Price: Low to High</option>
                                        <option value="high_low">Price: High to Low</option>
                                        <option value="new">New Added</option>
                                        <option value="sale">On Sale</option>
                                    </select>
                                </li>
                                <li>
                                    <select class="form-select" wire:model.live="perPage">
                                        <option value="12">Show: 12</option>
                                        <option value="16">Show: 16</option>
                                        <option value="20">Show: 20</option>
                                        <option value="24">Show: 24</option>
                                    </select>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- PRODUCT GRID -->
                <div class="row">
                    @forelse($products as $product)
                    <div class="col-xxl-3 col-6 col-md-4 col-lg-6 col-xl-4 wow fadeInUp">
                        {{-- Reusing your existing component --}}
                        <livewire:frontend.components.product
                            :product="$product"
                            :wire:key="'shop-prod-'.$product->id" />
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="alert alert-warning text-center">
                            No products found matching your criteria.
                            <button wire:click="$set('selectedCategory', null)" class="btn btn-sm btn-link">Clear Filters</button>
                        </div>
                    </div>
                    @endforelse
                </div>

                <!-- PAGINATION -->
                <div class="row">
                    <div class="pagination_area mt_50">
                        {{ $products->links('pagination::bootstrap-4') }}
                    </div>
                </div>

            </div>
            <!-- MAIN SHOP AREA END -->
        </div>
    </div>
</section>

{{-- SCRIPT to handle the Price Range Slider --}}
@push('scripts')
<script>
     $(document).ready(function() {
        // 1. Define options using standard jQuery UI syntax
        var sliderOptions = {
            range: true, // Standard jQuery UI accepts boolean here
            min: 0,
            max: 1000, // Adjust this if your max price is higher
            values: [{{ $minPrice ?? 0 }}, {{ $maxPrice ?? 1000 }}], 
            
            // 'slide': Updates UI while dragging (optional)
            slide: function(event, ui) {
                // Optional: Update visual text if your theme has specific spans
                $("#min_price_display").text("$" + ui.values[0]);
                $("#max_price_display").text("$" + ui.values[1]);
            },

            // 'stop': Triggers ONLY when user releases the handle (Best for Livewire)
            stop: function(event, ui) {
                @this.set('minPrice', ui.values[0]);
                @this.set('maxPrice', ui.values[1]);
            }
        };

        // 2. Initialize the Slider
        // We use .slider() directly to avoid errors in the theme's custom .alRangeSlider() wrapper
        if ($(".range_slider").length > 0) {
            // Destroy existing instance if it exists to prevent conflicts
            if ($(".range_slider").hasClass('ui-slider')) {
                $(".range_slider").slider("destroy");
            }
            $(".range_slider").slider(sliderOptions);
        }

        // 3. Listen for Reset Event
        Livewire.on('reset-price-slider', (data) => {
            let min = (data && data.min !== undefined) ? data.min : (data[0]?.min ?? 0);
            let max = (data && data.max !== undefined) ? data.max : (data[0]?.max ?? 1000);
            
            // Update the slider values visually
            $(".range_slider").slider("values", [min, max]);
        });
    });
</script>
@endpush