<section class="compare_page mt_100 mb_100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if($products->count() > 0)
                <div class="compare_list_area wow fadeInUp">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <!-- Product Images & Titles -->
                                <tr>
                                    <td>
                                        <p><b>Product</b></p>
                                    </td>
                                    @foreach($products as $product)
                                    <td>
                                        <img src="{{ $product->thumbnail_url }}" alt="product" class="img-fluid w-100">
                                        <a class="title" href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                                    </td>
                                    @endforeach
                                </tr>

                                <!-- Description -->
                                <tr>
                                    <td>
                                        <p><b>Description</b></p>
                                    </td>
                                    @foreach($products as $product)
                                    <td>
                                        <p>{{ Str::limit($product->short_description, 100) }}</p>
                                    </td>
                                    @endforeach
                                </tr>

                                <!-- Price -->
                                <tr>
                                    <td>
                                        <p><b>Price</b></p>
                                    </td>
                                    @foreach($products as $product)
                                    <td>
                                        <p>
                                            ${{ $product->price }}
                                            @if($product->offer_price) <del>${{ $product->offer_price }}</del> @endif
                                        </p>
                                    </td>
                                    @endforeach
                                </tr>

                                <!-- Size -->
                                <tr>
                                    <td>
                                        <p><b>Size</b></p>
                                    </td>
                                    @foreach($products as $product)
                                    <td>
                                        <p>{{ $product->sizes ?? 'N/A' }}</p>
                                    </td>
                                    @endforeach
                                </tr>

                                <!-- Rating (Dynamic Stars) -->
                                <tr>
                                    <td>
                                        <p><b>Rating</b></p>
                                    </td>
                                    @foreach($products as $product)
                                    <td>
                                        <p class="rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="{{ $i <= $product->ratings_avg ? 'fas fa-star' : 'fal fa-star' }}"></i>
                                                @endfor
                                        </p>
                                    </td>
                                    @endforeach
                                </tr>

                                <!-- Action Buttons -->
                                <tr>
                                    <td>
                                        <p><b>Action</b></p>
                                    </td>
                                    @foreach($products as $product)
                                    <td>
                                        <a href="javascript:void(0)" wire:click="addToCart({{ $product->id }})" class="common_btn">add to cart</a>
                                        <a href="javascript:void(0)" wire:click="removeFromCompare({{ $product->id }})" class="common_btn remove">
                                            <i class="fal fa-trash"></i>
                                        </a>
                                    </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                @else
                <div class="text-center">
                    <h4>No products in comparison list.</h4>
                    <a href="/" class="common_btn mt-3">Continue Shopping</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>