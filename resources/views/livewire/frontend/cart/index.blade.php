<section class="cart_page mt_100 mb_100">
    <div class="container">
        @if(count($groupedItems) > 0)
        <div class="row">
            <div class="col-lg-8 wow fadeInUp">
                <div class="cart_table_area">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="cart_page_checkbox">#</th>
                                    <th class="cart_page_img">Product image</th>
                                    <th class="cart_page_details">Product Details</th>
                                    <th class="cart_page_price">Unit Price</th>
                                    <th class="cart_page_quantity">Quantity</th>
                                    <th class="cart_page_total">Subtotal</th>
                                    <th class="cart_page_action">action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    @foreach($groupedItems as $vendorName => $items)
                    <div class="table-responsive mt-4">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="7">
                                        <h4 class="cart_vendor_name">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 24px;">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" />
                                            </svg>
                                            {{ $vendorName }}
                                        </h4>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                <tr wire:key="cart-item-{{ $item->id }}">
                                    <td class="cart_page_checkbox">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="cart_page_img">
                                        <div class="img">
                                            <img src="{{ $item->product->thumbnail_url }}" alt="{{ $item->product->name }}" class="img-fluid w-100">
                                        </div>
                                    </td>
                                    <td class="cart_page_details">
                                        <a class="title" href="{{ route('product.show', $item->product->slug) }}">{{ $item->product->name }}</a>
                                        <p>
                                            ৳{{ number_format($item->product->effective_price, 2) }}
                                            @if($item->product->price > $item->product->effective_price)
                                            <del>৳{{ number_format($item->product->price, 2) }}</del>
                                            @endif
                                        </p>
                                        @if($item->options)
                                        @foreach($item->options as $key => $val)
                                        <span><b>{{ ucfirst($key) }}:</b> {{ $val }}</span>
                                        @endforeach
                                        @endif
                                    </td>
                                    <td class="cart_page_price">
                                        <h3>৳{{ number_format($item->product->effective_price, 2) }}</h3>
                                    </td>
                                    <td class="cart_page_quantity">
                                        <div class="details_qty_input">
                                            <button class="minus" wire:click="decrement({{ $item->id }})"><i class="fal fa-minus"></i></button>
                                            <input type="text" value="{{ sprintf('%02d', $item->quantity) }}" readonly>
                                            <button class="plus" wire:click="increment({{ $item->id }})"><i class="fal fa-plus"></i></button>
                                        </div>
                                    </td>
                                    <td class="cart_page_total">
                                        <h3>৳{{ number_format($item->product->effective_price * $item->quantity, 2) }}</h3>
                                    </td>
                                    <td class="cart_page_action">
                                        <a href="javascript:void(0)" wire:click="removeItem({{ $item->id }})"> <i class="fal fa-times"></i> Remove</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-4 col-md-9 wow fadeInRight">
                <div id="sticky_sidebar">
                    <div class="cart_page_summary">
                        <h3>Billing summary</h3>

                        @foreach($groupedItems as $vendorName => $items)
                        <div class="vendor_summary_block mb-3">
                            <span class="vendor_name" style="font-weight: bold; font-size: 14px; color: #ff3c00;">
                                {{ $vendorName }}
                            </span>
                            <ul>
                                @foreach($items as $item)
                                <li>
                                    <a class="img" href="#">
                                        <img src="{{ $item->product->thumbnail_url }}" class="img-fluid w-100">
                                    </a>
                                    <div class="text">
                                        <a class="title" href="#">{{ Str::limit($item->product->name, 25) }}</a>
                                        <p>৳{{ number_format($item->product->effective_price, 2) }} × {{ $item->quantity }}</p>
                                        <p>
                                            @if($item->options)
                                            {{ collect($item->options)->map(fn($v, $k) => "$k: $v")->implode(', ') }}
                                            @endif
                                        </p>
                                    </div>
                                    </tr>
                                    @endforeach
                            </ul>
                        </div>
                        @endforeach

                        <h6>subtotal <span>৳{{ number_format($subtotal, 2) }}</span></h6>
                        <h6>Tax <span>(+) ৳{{ number_format($tax, 2) }}</span></h6>
                        <h6>Discount <span>(-) ৳{{ number_format($discount, 2) }}</span></h6>
                        <h4>Total <span>৳{{ number_format($total, 2) }}</span></h4>

                        <form action="#" wire:submit.prevent="applyCoupon">
                            <input type="text" placeholder="Coupon code">
                            <button type="submit" class="common_btn">Apply</button>
                        </form>
                    </div>
                    <div class="cart_summary_btn">
                        <a class="common_btn continue_shopping" href="{{ route('shop') }}" wire:navigate>Continue shopping</a>
                        <a class="common_btn" href="{{ route('user.checkout') }}" wire:navigate>checkout <i class="fas fa-long-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-12 text-center py-5">
                <h3>Your cart is empty</h3>
                <a href="{{ route('shop') }}" wire:navigate class="common_btn mt-3">Go to Shop</a>
            </div>
        </div>
        @endif
    </div>
</section>