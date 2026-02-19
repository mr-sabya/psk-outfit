<section class="checkout_page mt_100 mb_100">
    <div class="container">

        <div class="row">
            <div class="col-lg-8 wow fadeInUp">
                <div class="checkout_header mb-3">
                    <h3>Shipping Information</h3>
                </div>

                <div class="checkout_address_area">
                    @auth
                    <div class="row">
                        @foreach($addresses as $address)
                        <div class="col-md-6 mb-3">
                            <div class="checkout_single_address {{ $shipping_address_id == $address->id ? 'active_address' : '' }}"
                                style="cursor: pointer; border: 1px solid {{ $shipping_address_id == $address->id ? '#009e08' : '#eee' }}; padding: 15px; border-radius: 8px;"
                                wire:click="$set('shipping_address_id', {{ $address->id }})">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" wire:model.live="shipping_address_id" value="{{ $address->id }}">
                                    <label class="form-check-label w-100">
                                        <strong>{{ $address->first_name }} {{ $address->last_name }}</strong>
                                        <small class="text-muted">{{ $address->address_line_1 }}, {{ $address->city?->name }}</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mb-3"><button type="button" class="btn btn-sm btn-link p-0" wire:click="$set('shipping_address_id', null)">+ Use a different address</button></div>
                    @endauth

                    @if(!Auth::check() || !$shipping_address_id)
                    <div class="row wow fadeIn bg-light p-4 rounded mb-3">
                        <div class="col-md-12">
                            <div class="single_input">
                                <label>Full Name *</label>
                                <input type="text" wire:model="shipping.full_name">
                                @error('shipping.full_name') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="single_input">
                                <label>Email *</label>
                                <input type="email" wire:model="shipping.email">
                                @error('shipping.email') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="single_input">
                                <label>Phone *</label>
                                <input type="text" wire:model="shipping.phone">
                                @error('shipping.phone') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="single_input">
                                <label>Address Line 1 *</label>
                                <input type="text" wire:model="shipping.address_line_1">
                                @error('shipping.address_line_1') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="single_input">
                                <label>Country *</label>
                                <select wire:model.live="shipping.country_id" class="form-select">
                                    <option value="">Select Country</option>
                                    @foreach($countries as $c) <option value="{{ $c->id }}">{{ $c->name }}</option> @endforeach
                                </select>
                                @error('shipping.country_id') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="single_input"><label>State</label>
                                <select wire:model.live="shipping.state_id" class="form-select">
                                    <option value="">Select State</option>
                                    @foreach($shipping_states as $s) <option value="{{ $s->id }}">{{ $s->name }}</option> @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="single_input"><label>City</label>
                                <select wire:model.live="shipping.city_id" class="form-select">
                                    <option value="">Select City</option>
                                    @foreach($shipping_cities as $ct) <option value="{{ $ct->id }}">{{ $ct->name }}</option> @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="checkout_form_area mt-4">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" wire:model.live="bill_to_different_address" id="diffAddr">
                        <label class="form-check-label" for="diffAddr">Bill to a different address?</label>
                    </div>

                    @if($bill_to_different_address)
                    <div class="row wow fadeIn bg-light p-4 rounded mb-3">
                        <div class="col-md-12">
                            <div class="single_input">
                                <label>Full Name *</label>
                                <input type="text" wire:model="billing.full_name">
                                @error('billing.full_name') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="single_input">
                                <label>Address Line 1 *</label>
                                <input type="text" wire:model="billing.address_line_1">
                                @error('billing.address_line_1') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="single_input">
                                <label>Country *</label>
                                <select wire:model.live="billing.country_id" class="form-select">
                                    <option value="">Select</option>
                                    @foreach($countries as $c) <option value="{{ $c->id }}">{{ $c->name }}</option> @endforeach
                                </select>
                                @error('billing.country_id') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="single_input"><label>State</label>
                                <select wire:model.live="billing.state_id" class="form-select">
                                    <option value="">Select</option>
                                    @foreach($billing_states as $s) <option value="{{ $s->id }}">{{ $s->name }}</option> @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="single_input"><label>City</label>
                                <select wire:model.live="billing.city_id" class="form-select">
                                    <option value="">Select</option>
                                    @foreach($billing_cities as $ct) <option value="{{ $ct->id }}">{{ $ct->name }}</option> @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="col-xl-12 mt-3">
                        <div class="single_input"><label>Order notes (optional)</label><textarea rows="2" wire:model="order_notes"></textarea></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="cart_page_summary">
                    <h3>Billing summary</h3>
                    @foreach($groupedItems as $vendorName => $items)
                    <div class="vendor_name mt-3" style="font-weight: 700; color: #ff3c00;">{{ $vendorName }}</div>
                    <ul>
                        @foreach($items as $item)
                        <li>
                            <div class="img"><img src="{{ $item->product->thumbnail_url }}" class="img-fluid"></div>
                            <div class="text">
                                <a class="title">{{ Str::limit($item->product->name, 30) }}</a>
                                <div class="checkout_qty_wrapper d-flex align-items-center justify-content-between mt-2">
                                    <p class="mb-0">৳{{ number_format($item->product->effective_price, 2) }}</p>
                                    <div class="d-flex align-items-center border rounded">
                                        <button type="button" wire:click="decrementQuantity({{ $item->id }})" class="btn btn-sm px-2 py-0"><i class="fal fa-minus"></i></button>
                                        <span class="px-2 fw-bold">{{ $item->quantity }}</span>
                                        <button type="button" wire:click="incrementQuantity({{ $item->id }})" class="btn btn-sm px-2 py-0"><i class="fal fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    @endforeach

                    <div class="summary_info mt-4">
                        <h6>subtotal <span>৳{{ number_format($subtotal, 2) }}</span></h6>
                        <div class="checkout_shipping mt-3 mb-3 border-top pt-3">
                            <h6>Shipping Method</h6>
                            @foreach($shippingMethods as $method)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" wire:model.live="shipping_method_id" value="{{ $method->id }}" id="ship{{ $method->id }}">
                                <label class="form-check-label d-flex justify-content-between w-100" for="ship{{ $method->id }}">
                                    {{ $method->name }} <span>@if($shipping_method_id == $method->id) ৳{{ number_format($shipping_cost, 2) }} @endif</span>
                                </label>
                            </div>
                            @endforeach
                            @error('shipping_method_id') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <h4 class="border-top pt-3">Total <span style="color: #ff3c00;">৳{{ number_format($total, 2) }}</span></h4>
                    </div>
                </div>

                <div class="checkout_payment mt-4">
                    @if($paymentMethods->isNotEmpty())
                    <h3>payment method</h3>
                    <div wire:loading.remove wire:target="shipping_method_id">
                        @foreach($paymentMethods as $pay)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" wire:model.live="payment_method_id" value="{{ $pay->id }}" id="pay{{ $pay->id }}">
                            <label class="form-check-label" for="pay{{ $pay->id }}">{{ $pay->name }}</label>
                        </div>
                        @endforeach
                        @error('payment_method_id') <span class="text-danger small">{{ $message }}</span> @enderror

                        @if($selectedPayment)
                        <div class="p-3 bg-light border rounded mb-3 mt-2">
                            @if($selectedPayment->instructions)
                            <div class="payment_instructions mb-2">
                                <p class="mb-1" style="font-size: 14px; font-weight: 600;">Instructions:</p>
                                <div class="text-muted" style="font-size: 13px;">{!! nl2br(e($selectedPayment->instructions)) !!}</div>
                            </div>
                            @endif
                            @if($selectedPayment->type === 'direct')
                            <div class="single_input mt-3 mb-3">
                                <label>Payment Phone Number *</label>
                                <input type="text" wire:model="payment_phone_number" placeholder="017XXXXXXXX">
                                @error('payment_phone_number') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                            <div class="single_input mt-3">
                                <label>Transaction ID *</label>
                                <input type="text" wire:model="transaction_id" placeholder="Ex: TRX123456">
                                @error('transaction_id') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                            @endif
                        </div>
                        @endif
                    </div>
                    @endif

                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" wire:model="agree_terms" id="agree">
                        <label class="form-check-label small" for="agree">I have read and agree to the <a href="{{ route('page.show', 'terms-and-conditions') }}" target="_blank">Terms & Conditions</a> and <a href="{{ route('page.show', 'return-exchange-policy') }}" target="_blank">Return Policy</a></label>
                        <br>@error('agree_terms') <span class="text-danger small">{{ $message }}</span> @enderror
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