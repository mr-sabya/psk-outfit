<section class="best_selling_product_2 mt_95">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-sm-9">
                <div class="section_heading_2 section_heading">
                    <h3>Our <span>Best</span> Selling Products</h3>
                </div>
            </div>
            <div class="col-xl-6 col-sm-3">
                <div class="view_all_btn_area">
                    {{-- Assuming you have a route for the shop page --}}
                    <a class="view_all_btn" href="{{ route('shop') }}">View all</a>
                </div>
            </div>
        </div>

        <div class="row mt_15">
            {{-- Left Side: Grid of 3 Products --}}
            <div class="col-xl-7">
                <div class="row">
                    @forelse($gridProducts as $product)
                    <div class="col-xl-4 col-sm-6 col-md-4 wow fadeInUp">
                        <div class="best_selling_product_item" style="background: #f5f5f5;">
                            {{-- Image --}}
                            <div class="img_container">
                                <img src="{{ $product->thumbnail_url ?? asset('assets/frontend/images/best_sell_pro_img_1.jpg') }}"
                                    alt="{{ $product->name }}"
                                    class="img-fluid w-100">
                            </div>

                            <div class="text">
                                {{-- Title --}}
                                <a class="title" href="{{ route('product.show', $product->slug) }}" wire:navigate>
                                    {{ Str::limit($product->name, 25) }}
                                </a>

                                {{-- Price Logic --}}
                                <p class="price">
                                    {{ number_format($product->price, 2) }}

                                    @if($product->compare_at_price > $product->price)
                                    <del>{{ number_format($product->compare_at_price, 2) }}</del>
                                    @endif
                                </p>

                                {{-- Buy Button --}}
                                <a class="buy_btn" href="{{ route('product.show', $product->slug) }}" wire:navigate>
                                    buy now <i class="far fa-arrow-up"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <p>No products found.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Right Side: 1 Large Product (The 4th item) --}}
            <div class="col-xl-5 wow fadeInRight">
                <div class="best_selling_product_item_large">
                    <img src="{{ url('assets/frontend/images/best_sell_pro_img_4.jpg') }}" alt="best sell" class="img-fluid w-100">
                    <div class="text">
                        <a class="title" href="shop_details.html">Best Sales Discount And Offers</a>
                        <p class="price">$89.00 <del>$12.00</del></p>
                        <a class="common_btn" href="shop_details.html">buy now <i
                                class="fas fa-long-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>