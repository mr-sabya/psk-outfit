<section class="wishlist_page cart_page mt_100 mb_100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-10 col-xl-11">
                <div class="cart_table_area wow fadeInUp">

                    @if(count($wishlistGroups) > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="cart_page_img">Product image</th>
                                    <th class="cart_page_details">Product Details</th>
                                    <th class="cart_page_price">Unit Price</th>
                                    <th class="cart_page_quantity">Quantity</th>
                                    <th class="cart_page_action">add to cart</th>
                                    <th class="cart_page_action">remove</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    @foreach($wishlistGroups as $vendorName => $items)
                    {{-- Vendor Header --}}
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <td>
                                    <h4 class="cart_vendor_name">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" />
                                        </svg>
                                        {{ $vendorName }}
                                    </h4>
                                </td>
                            </tr>
                        </table>
                    </div>

                    {{-- Vendor Products --}}
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                @foreach($items as $item)
                                @php $product = $item->product; @endphp
                                <tr>
                                    <td class="cart_page_img">
                                        <div class="img">
                                            <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}" class="img-fluid w-100">
                                        </div>
                                    </td>
                                    <td class="cart_page_details">
                                        <a class="title" href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                                        <p>
                                            ৳{{ number_format($product->effective_price, 2) }}
                                            @if($product->price > $product->effective_price)
                                            <del>৳{{ number_format($product->price, 2) }}</del>
                                            @endif
                                        </p>
                                        {{-- Note: Static display as wishlists don't store variant selections in this single model --}}
                                        <span>SKU: {{ $product->sku }}</span>
                                    </td>
                                    <td class="cart_page_price">
                                        <h3>৳{{ number_format($product->effective_price, 2) }}</h3>
                                    </td>
                                    <td class="cart_page_quantity">
                                        <div class="details_qty_input">
                                            <button class="minus" wire:click="decrementQty({{ $product->id }})"><i class="fal fa-minus"></i></button>
                                            <input type="text" readonly value="{{ $quantities[$product->id] ?? 1 }}">
                                            <button class="plus" wire:click="incrementQty({{ $product->id }})"><i class="fal fa-plus"></i></button>
                                        </div>
                                    </td>
                                    <td class="cart_page_action">
                                        <button wire:click="moveToCart({{ $product->id }})" class="common_btn">add to cart</button>
                                    </td>
                                    <td class="cart_page_action">
                                        <button wire:click="removeItem({{ $product->id }})" class="common_btn remove">remove</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endforeach
                    @else
                    <div class="text-center p-5">
                        <h4>Your wishlist is empty!</h4>
                        <a href="{{ url('/shop') }}" class="common_btn mt-3">Continue Shopping</a>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</section>