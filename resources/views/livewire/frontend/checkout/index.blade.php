<section class="checkout_page mt_100 mb_100">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 wow fadeInUp">
                <div class="checkout_header mb-3">
                    <h3>Shipping Information</h3>
                    <p>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:20px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        account: <b>{{ Auth::user()->name }}</b>
                        <a href="#">(logout)</a>
                    </p>
                </div>

                {{-- Address Selection --}}
                <div class="checkout_address_area">
                    <div class="row">
                        @forelse($addresses as $address)
                        <div class="col-md-6 mb-3">
                            <div class="checkout_single_address {{ $shipping_address_id == $address->id ? 'active_address' : '' }}">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" wire:model.live="shipping_address_id"
                                        id="addr{{ $address->id }}" value="{{ $address->id }}">
                                    <label class="form-check-label" for="addr{{ $address->id }}">
                                        <span><i class="fal fa-map-marker-alt me-2"></i> {{ $address->address }}, {{ $address->city }}, {{ $address->zip }}</span>
                                        <span><i class="fal fa-envelope me-2"></i> {{ Auth::user()->email }}</span>
                                        <span><i class="fal fa-phone me-2"></i> {{ $address->phone ?? Auth::user()->phone }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <p>No addresses found. <a href="{{ route('user.address') }}">Add New Address</a></p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <form class="checkout_form_area" wire:submit.prevent="placeOrder">
                    {{-- Bill to different address checkbox --}}
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" wire:model.live="bill_to_different_address" id="diffAddr">
                        <label class="form-check-label" for="diffAddr">Bill to a different address?</label>
                    </div>

                    @if($bill_to_different_address)
                    <div class="row wow fadeIn">
                        <div class="col-md-6">
                            <div class="single_input"><label>Name *</label><input type="text" wire:model="billing.name"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="single_input"><label>Email *</label><input type="email" wire:model="billing.email"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="single_input"><label>Phone</label><input type="text" wire:model="billing.phone"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="single_input"><label>Zip</label><input type="text" wire:model="billing.zip"></div>
                        </div>
                        <div class="col-12">
                            <div class="single_input"><label>Address</label><textarea rows="3" wire:model="billing.address"></textarea></div>
                        </div>
                    </div>
                    @endif

                    <div class="col-xl-12">
                        <div class="single_input">
                            <label>Order notes (optional)</label>
                            <textarea rows="2" wire:model="order_notes" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4 col-md-9 wow fadeInRight">
                <div class="cart_page_summary">
                    <h3>Billing summary</h3>

                    @foreach($groupedItems as $vendorName => $items)
                    <div class="vendor_name mt-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:20px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" />
                        </svg>
                        {{ $vendorName }}
                    </div>
                    <ul>
                        @foreach($items as $item)
                        <li>
                            <div class="img"><img src="{{ $item->product->thumbnail_url }}" class="img-fluid"></div>
                            <div class="text">
                                <a class="title">{{ $item->product->name }}</a>
                                <p>৳{{ number_format($item->product->effective_price, 2) }} × {{ $item->quantity }}</p>
                                <p>
                                    @if($item->options)
                                    {{ collect($item->options)->map(fn($v, $k) => "$k: $v")->implode(', ') }}
                                    @endif
                                </p>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    @endforeach

                    <div class="summary_info mt-4">
                        <h6>subtotal <span>৳{{ number_format($subtotal, 2) }}</span></h6>
                        <h6>Tax <span>(+) ৳{{ number_format($tax, 2) }}</span></h6>
                        <h6>Discount <span>(-) ৳{{ number_format($discount, 2) }}</span></h6>
                        <h4>Subtotal <span>৳{{ number_format($subtotal - $discount, 2) }}</span></h4>

                        <div class="checkout_shipping">
                            <h6>Shipping method</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" wire:model.live="shipping_method" id="ship1" value="flat_rate">
                                <label class="form-check-label" for="ship1">Flat rate: <span>(+) ৳15.00</span></label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" wire:model.live="shipping_method" id="ship2" value="local_pickup">
                                <label class="form-check-label" for="ship2">Local pickup: <span>(+) ৳19.00</span></label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" wire:model.live="shipping_method" id="ship3" value="free_shipping">
                                <label class="form-check-label" for="ship3">Free shipping</label>
                            </div>
                        </div>
                        <h4>Total <span>৳{{ number_format($total, 2) }}</span></h4>
                    </div>
                </div>

                <div class="checkout_payment">
                    <h3>payment method</h3>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" wire:model="payment_method" id="pay1" value="bank">
                        <label class="form-check-label" for="pay1">Direct Bank Transfer</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" wire:model="payment_method" id="pay3" value="cod">
                        <label class="form-check-label" for="pay3">Cash on Delivery</label>
                    </div>

                    <div class="terms mt-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model="agree_terms" id="agree">
                            <label class="form-check-label" for="agree">I have read and agree to the website.</label>
                        </div>
                        @error('agree_terms') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <button type="button" wire:click="placeOrder" class="common_btn w-100 mt-3" wire:loading.attr="disabled">
                        <span wire:loading.remove>Place order <i class="fas fa-long-arrow-right"></i></span>
                        <span wire:loading>Processing...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>