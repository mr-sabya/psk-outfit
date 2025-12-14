<section class="special_product_2 pt_85">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-sm-9">
                <div class="section_heading_2 section_heading">
                    <h3>Our <span>Special</span> Brand Products</h3>
                </div>
            </div>
            <div class="col-xl-6 col-sm-3">
                <div class="view_all_btn_area">
                    {{-- Adjust route name as per your web.php --}}
                    <a class="view_all_btn" href="{{ route('shop') }}">View all</a>
                </div>
            </div>
        </div>

        <div class="row pt_15">
            {{-- Static Banner Section (Left Side) --}}
            <div class="col-xl-4 wow fadeInLeft">
                <div class="special_product_banner">
                    <img src="{{ asset('assets/frontend/images/home2_special_banner.jpg') }}" alt="special product" class="img-fluid w-100">
                    <div class="text">
                        <h3>make your fashion look more changing</h3>
                        <p>Get 50% Off on Selected Clothing Items</p>
                        <a class="common_btn" href="{{ route('shop') }}">shop now <i
                                class="fas fa-long-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Dynamic Product Grid (Right Side) --}}
            <div class="col-xl-8">
                <div class="row">
                    @forelse($products as $product)
                    <div class="col-md-6 wow fadeInUp">
                        <div class="special_product_item">
                            <div class="special_product_img">
                                {{-- Use the accessor from Product Model --}}
                                <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}" class="img-fluid w-100">

                                {{-- Calculate Discount Badge --}}
                                @php
                                $price = $product->effective_price;
                                $comparePrice = $product->compare_at_price;
                                $saveAmount = 0;

                                if($comparePrice > $price) {
                                $saveAmount = $comparePrice - $price;
                                }
                                @endphp

                                @if($saveAmount > 0)
                                <span class="discount">save ${{ number_format($saveAmount, 0) }}</span>
                                @endif
                            </div>

                            <div class="special_product_text">
                                {{-- Adjust route to your product details route --}}
                                <a class="title" href="#">
                                    {{ $product->name }}
                                </a>

                                {{-- Dynamic Star Ratings --}}
                                <span>
                                    @php
                                    $rating = $product->reviews_avg_rating ?? 0;
                                    $fullStars = floor($rating);
                                    $halfStar = $rating - $fullStars >= 0.5;
                                    $emptyStars = 5 - ($fullStars + ($halfStar ? 1 : 0));
                                    @endphp

                                    @for ($i = 0; $i < $fullStars; $i++)
                                        <i class="fas fa-star"></i>
                                        @endfor

                                        @if ($halfStar)
                                        <i class="fas fa-star-half-alt"></i>
                                        @endif

                                        @for ($i = 0; $i < $emptyStars; $i++)
                                            <i class="far fa-star"></i>
                                            @endfor
                                </span>

                                {{-- Price Display --}}
                                <p>
                                    ${{ number_format($price, 2) }}
                                    @if($comparePrice > $price)
                                    <del>${{ number_format($comparePrice, 2) }}</del>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <p class="text-center">No special products found.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>