<div id="">
    <div class="shop_details_sidebar">
        <div class="row">
            <div class="col-xxl-12 col-md">
                <div class="shop_details_sidebar_info">
                    {!! $settings['product_sideinfo'] ?? '' !!}
                </div>
            </div>
            {{-- VENDOR SECTION --}}
            @if($product->vendor)
            <div class="col-xxl-12 col-md">
                <div class="shop_details_sidebar_store">
                    <p class="sold_by">Sold by</p>
                    <h4 class="store_name">{{ $product->vendor->name }}</h4>
                    <ul>
                        <li>
                            <p>Seller Ratings</p>
                            {{-- Calculate rating from vendor's reviews --}}
                            @php
                            // If you don't have direct vendor ratings, use product ratings as proxy or add relation
                            $vendorRating = $product->vendor->vendor_avg_rating ?? 4.5;
                            $vendorReviewCount = $product->vendor->vendor_reviews_count ?? 0;
                            @endphp
                            <span>{{ number_format($vendorRating, 1) }} ({{ $vendorReviewCount }})</span>
                        </li>
                        <li>
                            <p>Ship on Time</p>
                            {{-- Assuming column on User model --}}
                            <span>{{ $product->vendor->ship_on_time_pct ?? '98' }}%</span>
                        </li>
                        <li>
                            <p>Chat Response Rate</p>
                            {{-- Assuming column on User model --}}
                            <span>{{ $product->vendor->response_rate_pct ?? '95' }}%</span>
                        </li>
                    </ul>
                    {{-- Make sure named route 'vendor.details' exists --}}
                    <a class="go_store" href="#">Go To Store</a>
                    <a class="chat" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                        </svg>
                        Chat Now
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>