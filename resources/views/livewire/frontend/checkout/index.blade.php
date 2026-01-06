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

                <div class="checkout_address_area">
                    <div class="row">
                        @forelse($addresses as $address)
                        <div class="col-md-6 mb-3">
                            <div class="checkout_single_address {{ $shipping_address_id == $address->id ? 'active_address' : '' }}"
                                style="cursor: pointer; border: 1px solid {{ $shipping_address_id == $address->id ? '#ff3c00' : '#eee' }}; padding: 15px; border-radius: 8px;">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" wire:model.live="shipping_address_id"
                                        id="addr{{ $address->id }}" value="{{ $address->id }}">

                                    <label class="form-check-label w-100" for="addr{{ $address->id }}">
                                        <span class="d-block mb-1">
                                            <strong>{{ $address->first_name }} {{ $address->last_name }}</strong>
                                            <small class="badge bg-secondary ms-2">{{ ucfirst($address->type) }}</small>
                                        </span>

                                        <span class="d-block small text-muted mb-1">
                                            <i class="fal fa-map-marker-alt me-2"></i>
                                            {{ $address->address_line_1 }}@if($address->address_line_2), {{ $address->address_line_2 }}@endif,
                                            {{ $address->city?->name }}, {{ $address->zip_code }}
                                        </span>

                                        <span class="d-block small text-muted mb-1">
                                            <i class="fal fa-envelope me-2"></i> {{ $address->email }}
                                        </span>

                                        <span class="d-block small text-muted">
                                            <i class="fal fa-phone me-2"></i> {{ $address->phone }}
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center py-4 border rounded">
                            <p class="mb-3">No saved addresses found.</p>
                            <a href="{{ route('user.address.create') }}" class="common_btn">Add New Address</a>
                        </div>
                        @endforelse
                    </div>
                    @error('shipping_address_id') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <form class="checkout_form_area mt-4" wire:submit.prevent="placeOrder">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" wire:model.live="bill_to_different_address" id="diffAddr">
                        <label class="form-check-label" for="diffAddr" style="font-weight: 600;">Bill to a different address?</label>
                    </div>

                    @if($bill_to_different_address)
                    <div class="row wow fadeIn bg-light p-3 rounded mb-3">
                        <div class="col-md-6">
                            <div class="single_input"><label>First Name *</label><input type="text" wire:model="billing.first_name"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="single_input"><label>Last Name *</label><input type="text" wire:model="billing.last_name"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="single_input"><label>Email *</label><input type="email" wire:model="billing.email"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="single_input"><label>Phone *</label><input type="text" wire:model="billing.phone"></div>
                        </div>
                        <div class="col-md-8">
                            <div class="single_input"><label>Address *</label><input type="text" wire:model="billing.address_line_1"></div>
                        </div>
                        <div class="col-md-4">
                            <div class="single_input"><label>Zip *</label><input type="text" wire:model="billing.zip_code"></div>
                        </div>
                    </div>
                    @endif

                    <div class="col-xl-12 mt-3">
                        <div class="single_input">
                            <label>Order notes (optional)</label>
                            <textarea rows="2" wire:model="order_notes" placeholder="Notes about your order..."></textarea>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-lg-4 col-md-9 wow fadeInRight">
                <div class="cart_page_summary">
                    <h3>Billing summary</h3>

                    @foreach($groupedItems as $vendorName => $items)
                    <div class="vendor_name mt-3 d-flex justify-content-between align-items-center" style="font-weight: 700; color: #ff3c00;">
                        <span><i class="fas fa-store me-2"></i> {{ $vendorName }}</span>
                        @if($this->isEligibleForFreeShipping($items))
                        <span class="badge bg-success" style="font-size: 10px;">Free Ship Qualified</span>
                        @endif
                    </div>
                    <ul>
                        @foreach($items as $item)
                        @php
                        $displayPrice = $item->product->effective_price;
                        if($item->is_combo && $item->main_product_id && $item->product_id != $item->main_product_id) {
                            $displayPrice = $item->mainProduct->getComboDiscount($item->product_id) ?? $displayPrice;
                        }
                        @endphp
                        <li>
                            <div class="img"><img src="{{ $item->product->thumbnail_url }}" class="img-fluid"></div>
                            <div class="text">
                                <a class="title">{{ Str::limit($item->product->name, 30) }}</a>
                                <div class="checkout_qty_wrapper d-flex align-items-center justify-content-between mt-2">
                                    <p class="mb-0">
                                        ৳{{ number_format($displayPrice, 2) }}
                                        @if($item->is_combo && $item->product_id != $item->main_product_id)
                                        <span class="badge bg-info" style="font-size: 8px;">Combo Price</span>
                                        @endif
                                    </p>

                                    <div class="d-flex align-items-center border rounded">
                                        <button type="button" wire:click="decrementQuantity({{ $item->id }})" class="btn btn-sm px-2 py-0 border-end" style="font-size: 12px;"><i class="fal fa-minus"></i></button>
                                        <span class="px-3 fw-bold" style="font-size: 14px;">{{ $item->quantity }}</span>
                                        <button type="button" wire:click="incrementQuantity({{ $item->id }})" class="btn btn-sm px-2 py-0 border-start" style="font-size: 12px;"><i class="fal fa-plus"></i></button>
                                    </div>

                                    <button type="button" wire:click="removeItem({{ $item->id }})" class="btn btn-sm text-danger ms-2"><i class="fal fa-trash-alt"></i></button>
                                </div>
                                @if($item->options)
                                <p class="small text-muted">
                                    {{ collect($item->options)->map(fn($v, $k) => "$k: $v")->implode(', ') }}
                                </p>
                                @endif
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    @endforeach

                    <div class="summary_info mt-4">
                        <h6>subtotal <span>৳{{ number_format($subtotal, 2) }}</span></h6>
                        <h6>Tax <span>(+) ৳{{ number_format($tax, 2) }}</span></h6>
                        <h6>Discount <span>(-) ৳{{ number_format($discount, 2) }}</span></h6>

                        <div class="checkout_shipping mt-3 mb-3 border-top pt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6>Shipping method</h6>
                                @if($freeShippingActive)
                                <span class="badge bg-success"><i class="fas fa-truck me-1"></i> Free Shipping Applied</span>
                                @endif
                            </div>
                            @foreach($shippingMethods as $method)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" wire:model.live="shipping_method_id"
                                    id="ship{{ $method->id }}" value="{{ $method->id }}">
                                <label class="form-check-label d-flex justify-content-between w-100" for="ship{{ $method->id }}">
                                    {{ $method->name }}
                                    @if($shipping_address_id && $shipping_method_id == $method->id)
                                    <span>
                                        @if($freeShippingActive) ৳0.00 @else ৳{{ number_format($shipping_cost, 2) }} @endif
                                    </span>
                                    @endif
                                </label>
                            </div>
                            @endforeach
                        </div>

                        <h4 class="border-top pt-3">Total <span style="color: #ff3c00;">৳{{ number_format($total, 2) }}</span></h4>
                    </div>
                </div>

                <div class="checkout_payment mt-4">
                    <h3>payment method</h3>
                    @foreach($paymentMethods as $pay)
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" wire:model.live="payment_method_id"
                            id="pay{{ $pay->id }}" value="{{ $pay->id }}">
                        <label class="form-check-label" for="pay{{ $pay->id }}">
                            {{ $pay->name }}
                        </label>
                    </div>
                    @endforeach

                    @if($selectedPayment && $selectedPayment->type === 'direct')
                    <div class="p-3 bg-light border rounded mb-3 mt-2">
                        <p class="small text-danger mb-2"><strong>Instructions:</strong> {{ $selectedPayment->instructions }}</p>
                        <div class="single_input">
                            <label>Transaction ID *</label>
                            <input type="text" wire:model="transaction_id" placeholder="e.g. 8N77XCW9">
                            @error('transaction_id') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    @endif

                    <div class="terms mt-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model="agree_terms" id="agree">
                            <label class="form-check-label small" for="agree">I have read and agree to the website <a href="#" class="text-primary">terms and conditions</a>.</label>
                        </div>
                        @error('agree_terms') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <button type="button" wire:click="placeOrder" class="common_btn w-100 mt-3" wire:loading.attr="disabled">
                        <span wire:loading.remove>Place order <i class="fas fa-long-arrow-right"></i></span>
                        <span wire:loading>Processing... <i class="fas fa-spinner fa-spin"></i></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>