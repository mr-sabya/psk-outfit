<section class="cart_page mt_100 mb_100 bg-light-subtle">
    <div class="container">
        @if(count($cartItems) > 0)
        <div class="row g-4">
            <!-- Left Side: Item List -->
            <div class="col-lg-8">
                <div class="p-4 bg-white rounded-4 shadow-sm border-0">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold mb-0">Shopping Cart <span class="text-muted fs-6">({{ count($cartItems) }} items)</span></h4>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="text-muted small uppercase">
                                <tr>
                                    <th class="border-0 ps-0">Product</th>
                                    <th class="border-0">Price</th>
                                    <th class="border-0 text-center">Quantity</th>
                                    <th class="border-0 text-end pe-0">Total</th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0">
                                @foreach($cartItems as $item)
                                <tr wire:key="cart-item-{{ $item->id }}">
                                    <!-- Product Info -->
                                    <td class="ps-0 py-4" style="min-width: 300px;">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-3 overflow-hidden border me-3" style="width: 80px; height: 80px; flex-shrink: 0;">
                                                <img src="{{ $item->product->thumbnail_url }}" alt="{{ $item->product->name }}" class="img-fluid w-100 h-100 object-fit-cover">
                                            </div>
                                            <div>
                                                <a class="text-dark fw-bold text-decoration-none d-block mb-1" href="{{ route('product.show', $item->product->slug) }}">
                                                    {{ Str::limit($item->product->name, 40) }}
                                                </a>
                                                @if($item->options)
                                                <div class="small text-muted">
                                                    @foreach($item->options as $key => $val)
                                                    <span class="me-2"><b class="text-dark">{{ ucfirst($key) }}:</b> {{ $val }}</span>
                                                    @endforeach
                                                </div>
                                                @endif
                                                <button wire:click="removeItem({{ $item->id }})" class="btn btn-link btn-sm p-0 text-danger mt-2 text-decoration-none small">
                                                    <i class="fal fa-trash-alt me-1"></i> Remove
                                                </button>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Unit Price -->
                                    <td class="py-4">
                                        <div class="fw-bold">৳{{ number_format($item->product->effective_price, 2) }}</div>
                                        @if($item->product->price > $item->product->effective_price)
                                        <del class="text-muted small">৳{{ number_format($item->product->price, 2) }}</del>
                                        @endif
                                    </td>

                                    <!-- Quantity Control -->
                                    <td class="py-4 text-center">
                                        <div class="d-inline-flex align-items-center border rounded-pill bg-light p-1">
                                            <button class="btn btn-sm btn-light rounded-circle border-0 shadow-none" wire:click="decrement({{ $item->id }})"><i class="fal fa-minus"></i></button>
                                            <input type="text" class="form-control form-control-sm text-center border-0 bg-transparent fw-bold" style="width: 40px;" value="{{ $item->quantity }}" readonly>
                                            <button class="btn btn-sm btn-light rounded-circle border-0 shadow-none" wire:click="increment({{ $item->id }})"><i class="fal fa-plus"></i></button>
                                        </div>
                                    </td>

                                    <!-- Row Total -->
                                    <td class="py-4 text-end pe-0">
                                        <h5 class="fw-bold text-dark mb-0">৳{{ number_format($item->product->effective_price * $item->quantity, 2) }}</h5>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Side: Order Summary -->
            <div class="col-lg-4">
                <div class="sticky-top" style="top: 120px;">
                    <div class="p-4 bg-white rounded-4 shadow-sm border-0 mb-4">
                        <h5 class="fw-bold mb-4">Order Summary</h5>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-bold">৳{{ number_format($subtotal, 2) }}</span>
                        </div>

                        @if($discount > 0)
                        <div class="d-flex justify-content-between mb-3 text-success">
                            <span>Discount ({{ $appliedCoupon->code }})
                                <button wire:click="removeCoupon" class="btn btn-link btn-sm p-0 text-danger ms-1"><i class="fal fa-times-circle"></i></button>
                            </span>
                            <span class="fw-bold">-৳{{ number_format($discount, 2) }}</span>
                        </div>
                        @endif

                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Estimated Tax</span>
                            <span class="fw-bold">৳{{ number_format($tax, 2) }}</span>
                        </div>

                        <hr class="my-4 border-light">

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="h5 fw-bold mb-0">Total</span>
                            <span class="h4 fw-bold text-primary mb-0">৳{{ number_format($total, 2) }}</span>
                        </div>

                        <!-- Coupon Form -->
                        @if(!Session::has('coupon'))
                        <div class="mb-4">
                            <div class="input-group">
                                <input type="text" class="form-control border-end-0" placeholder="Promo code" wire:model="couponCode">
                                <button class="btn btn-dark px-4" type="button" wire:click="applyCoupon" wire:loading.attr="disabled">
                                    <span wire:loading.remove wire:target="applyCoupon">Apply</span>
                                    <span wire:loading wire:target="applyCoupon" class="spinner-border spinner-border-sm"></span>
                                </button>
                            </div>
                        </div>
                        @else
                        <div class="alert alert-success d-flex align-items-center border-0 small py-2 mb-4">
                            <i class="fas fa-ticket-alt me-2"></i> Coupon <b>{{ Session::get('coupon')['code'] }}</b> active!
                        </div>
                        @endif

                        <a href="{{ route('checkout') }}" wire:navigate class="btn btn-success w-100 py-3 rounded-pill fw-bold shadow-sm">
                            Proceed to Checkout <i class="fas fa-long-arrow-right ms-2"></i>
                        </a>
                        <a href="{{ route('shop') }}" wire:navigate class="btn btn-link w-100 text-muted mt-2 text-decoration-none small">
                            <i class="fal fa-arrow-left me-1"></i> Continue Shopping
                        </a>
                    </div>

                    <!-- Trust Badges -->
                    <!-- <div class="text-center">
                        <p class="small text-muted mb-2"><i class="fas fa-shield-check me-1"></i> Secure Checkout Guaranteed</p>
                        <div class="d-flex justify-content-center gap-2">
                            <img src="{{ asset('payment-icons.png') }}" alt="Payments" style="max-width: 180px; opacity: 0.6;">
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
        @else
        <div class="row justify-content-center">
            <div class="col-md-6 text-center py-5">
                <div class="mb-4">
                    <i class="fal fa-shopping-cart fa-5x text-light"></i>
                </div>
                <h3 class="fw-bold">Your cart feels lonely.</h3>
                <p class="text-muted">Looks like you haven't added anything to your cart yet.</p>
                <a href="{{ route('shop') }}" wire:navigate class="btn btn-primary px-5 py-3 rounded-pill mt-3 shadow">
                    Start Shopping
                </a>
            </div>
        </div>
        @endif
    </div>

    <style>
        /* Professional Cart Enhancements */
        .cart_page {
            background-color: #f9f9fb;
            /* Subtle grey background for the whole page */
        }

        .rounded-4 {
            border-radius: 1.25rem !important;
        }

        /* Quantity Controls */
        .details_qty_input .btn-light {
            background-color: #fff;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .details_qty_input .btn-light:hover {
            background-color: #ff3c00;
            /* Your Brand Color */
            color: #fff;
        }

        /* Table Enhancements */
        .table td {
            border-bottom: 1px solid #f1f1f1;
        }

        .table tr:last-child td {
            border-bottom: 0;
        }

        /* Primary Color Override (Change #ff3c00 to your brand color) */
        .text-primary {
            color: #ff3c00 !important;
        }

        .btn-primary {
            background-color: #ff3c00 !important;
            border-color: #ff3c00 !important;
        }

        .btn-primary:hover {
            background-color: #e63600 !important;
        }

        /* Transitions */
        .common_btn,
        .btn {
            transition: all 0.3s ease;
        }
    </style>
</section>