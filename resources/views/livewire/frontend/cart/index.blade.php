<section class="cart_page mt_100 mb_100">
    <div class="container">
        @if(count($cartItems) > 0)
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
                            <tbody>
                                @foreach($cartItems as $item)
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
                                    <td class="cart_page_price text-nowrap">
                                        <h3>৳{{ number_format($item->product->effective_price, 2) }}</h3>
                                    </td>
                                    <td class="cart_page_quantity">
                                        <div class="details_qty_input">
                                            <button class="minus" wire:click="decrement({{ $item->id }})"><i class="fal fa-minus"></i></button>
                                            <input type="text" value="{{ sprintf('%02d', $item->quantity) }}" readonly>
                                            <button class="plus" wire:click="increment({{ $item->id }})"><i class="fal fa-plus"></i></button>
                                        </div>
                                    </td>
                                    <td class="cart_page_total text-nowrap">
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
                </div>
            </div>

            <div class="col-lg-4 col-md-9 wow fadeInRight">
                <div id="sticky_sidebar">
                    <div class="cart_page_summary">
                        <h3>Billing summary</h3>

                        <!-- Financial Calculations -->
                        <h6>subtotal <span>৳{{ number_format($subtotal, 2) }}</span></h6>
                        <h6>Tax <span>(+) ৳{{ number_format($tax, 2) }}</span></h6>

                        @if($discount > 0)
                        <h6 class="text-success">
                            Discount ({{ $appliedCoupon->code }})
                            <a href="javascript:void(0)" wire:click="removeCoupon" class="text-danger small ms-2"><i class="fal fa-times"></i></a>
                            <span>(-) ৳{{ number_format($discount, 2) }}</span>
                        </h6>
                        @endif

                        <h4>Total <span>৳{{ number_format($total, 2) }}</span></h4>

                        <!-- Coupon Form -->
                        @if(!Session::has('coupon'))
                        <form wire:submit.prevent="applyCoupon">
                            <input type="text" placeholder="Coupon code" wire:model="couponCode">
                            <button type="submit" class="common_btn" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="applyCoupon">Apply</span>
                                <span wire:loading wire:target="applyCoupon">...</span>
                            </button>
                        </form>
                        @else
                        <div class="alert alert-success py-2 mt-3 small">
                            <i class="fas fa-ticket-alt"></i> Coupon <b>{{ Session::get('coupon')['code'] }}</b> applied!
                        </div>
                        @endif
                    </div>

                    <div class="cart_summary_btn">
                        <a class="common_btn continue_shopping" href="{{ route('shop') }}" wire:navigate>Continue shopping</a>
                        <a class="common_btn" href="{{ route('checkout') }}" wire:navigate>checkout <i class="fas fa-long-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- Empty Cart State -->
        <div class="row">
            <div class="col-12 text-center py-5">
                <h3>Your cart is empty</h3>
                <a href="{{ route('shop') }}" wire:navigate class="common_btn mt-3">Go to Shop</a>
            </div>
        </div>
        @endif
    </div>
</section>