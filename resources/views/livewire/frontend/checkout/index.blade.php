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
                        @auth
                        account: <b>{{ Auth::user()->name }}</b> <a href="#">(logout)</a>
                        @else
                        account: <b>Guest</b> <a href="{{ route('login') }}">(login?)</a>
                        @endauth
                    </p>
                </div>

                <div class="checkout_address_area">
                    @auth
                    <div class="row">
                        @foreach($addresses as $address)
                        <div class="col-md-6 mb-3">
                            <div class="checkout_single_address {{ $shipping_address_id == $address->id ? 'active_address' : '' }}"
                                style="cursor: pointer; border: 1px solid {{ $shipping_address_id == $address->id ? '#ff3c00' : '#eee' }}; padding: 15px; border-radius: 8px;"
                                wire:click="$set('shipping_address_id', {{ $address->id }})">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" wire:model.live="shipping_address_id" value="{{ $address->id }}">
                                    <label class="form-check-label w-100">
                                        <span class="d-block mb-1"><strong>{{ $address->first_name }} {{ $address->last_name }}</strong></span>
                                        <span class="d-block small text-muted mb-1"><i class="fal fa-map-marker-alt me-2"></i> {{ $address->address_line_1 }}, {{ $address->city?->name }}</span>
                                        <span class="d-block small text-muted"><i class="fal fa-phone me-2"></i> {{ $address->phone }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mb-3"><button type="button" class="btn btn-sm btn-link p-0" wire:click="$set('shipping_address_id', null)">+ Use a different address</button></div>
                    @endauth

                    {{-- GUEST FORM / NEW ADDRESS FORM --}}
                    @if(!Auth::check() || !$shipping_address_id)
                    <div class="row wow fadeIn bg-light p-3 rounded mb-3">
                        <div class="col-md-6">
                            <div class="single_input"><label>First Name *</label><input type="text" wire:model="shipping.first_name"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="single_input"><label>Last Name</label><input type="text" wire:model="shipping.last_name"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="single_input"><label>Email *</label><input type="email" wire:model="shipping.email"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="single_input"><label>Phone *</label><input type="text" wire:model="shipping.phone"></div>
                        </div>
                        <div class="col-md-12">
                            <div class="single_input"><label>Address *</label><input type="text" wire:model="shipping.address_line_1"></div>
                        </div>
                        <div class="col-md-4">
                            <div class="single_input"><label>Country *</label>
                                <select wire:model.live="shipping.country_id" class="form-control form-select">
                                    <option value="">Select</option>
                                    @foreach($countries as $c) <option value="{{ $c->id }}">{{ $c->name }}</option> @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="single_input"><label>State</label>
                                <select wire:model.live="shipping.state_id" class="form-control form-select">
                                    <option value="">Select</option>
                                    @foreach($states as $s) <option value="{{ $s->id }}">{{ $s->name }}</option> @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="single_input"><label>Zip</label><input type="text" wire:model="shipping.zip_code"></div>
                        </div>
                    </div>
                    @endif
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
                        <div class="single_input"><label>Order notes (optional)</label><textarea rows="2" wire:model="order_notes" placeholder="Notes..."></textarea></div>
                    </div>
                </form>
            </div>

            <div class="col-lg-4 col-md-9 wow fadeInRight">
                <div class="cart_page_summary">
                    <h3>Billing summary</h3>
                    @foreach($groupedItems as $vendorName => $items)
                    <div class="vendor_name mt-3 d-flex justify-content-between align-items-center" style="font-weight: 700; color: #ff3c00;">
                        <span><i class="fas fa-store me-2"></i> {{ $vendorName }}</span>
                        @if($this->isEligibleForFreeShipping($items)) <span class="badge bg-success" style="font-size: 10px;">Free Ship Qualified</span> @endif
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
                                    <p class="mb-0">৳{{ number_format($displayPrice, 2) }}</p>
                                    <div class="d-flex align-items-center border rounded">
                                        <button type="button" wire:click="decrementQuantity({{ $item->id }})" class="btn btn-sm px-2 py-0 border-end"><i class="fal fa-minus"></i></button>
                                        <span class="px-3 fw-bold">{{ $item->quantity }}</span>
                                        <button type="button" wire:click="incrementQuantity({{ $item->id }})" class="btn btn-sm px-2 py-0 border-start"><i class="fal fa-plus"></i></button>
                                    </div>
                                    <button type="button" wire:click="removeItem({{ $item->id }})" class="btn btn-sm text-danger ms-2"><i class="fal fa-trash-alt"></i></button>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    @endforeach

                    <div class="summary_info mt-4">
                        <h6>subtotal <span>৳{{ number_format($subtotal, 2) }}</span></h6>
                        <div class="checkout_shipping mt-3 mb-3 border-top pt-3">
                            <div class="d-flex justify-content-between">
                                <h6>Shipping</h6> @if($freeShippingActive) <span class="badge bg-success">Free Applied</span> @endif
                            </div>
                            @foreach($shippingMethods as $method)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" wire:model.live="shipping_method_id" value="{{ $method->id }}" id="ship{{ $method->id }}">
                                <label class="form-check-label d-flex justify-content-between w-100" for="ship{{ $method->id }}">
                                    {{ $method->name }} <span>@if($freeShippingActive && $shipping_method_id == $method->id) ৳0.00 @elseif($shipping_method_id == $method->id) ৳{{ number_format($shipping_cost, 2) }} @endif</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                        <h4 class="border-top pt-3">Total <span style="color: #ff3c00;">৳{{ number_format($total, 2) }}</span></h4>
                    </div>
                </div>

                <div class="checkout_payment mt-4">
                    <h3>payment method</h3>
                    <!-- Add a loading state for when shipping changes -->
                    <div wire:loading wire:target="shipping_method_id" class="small text-muted mb-2">
                        Updating available payment methods...
                    </div>

                    @forelse($paymentMethods as $pay)
                    <div class="form-check mb-2" wire:key="pay-{{ $pay->id }}">
                        <input class="form-check-input" type="radio"
                            wire:model.live="payment_method_id"
                            value="{{ $pay->id }}"
                            id="pay{{ $pay->id }}">
                        <label class="form-check-label" for="pay{{ $pay->id }}">{{ $pay->name }}</label>
                    </div>
                    @empty
                    <p class="text-danger small">No payment methods available for this shipping selection.</p>
                    @endforelse

                    @if($selectedPayment && $selectedPayment->type === 'direct')
                    <div class="p-3 bg-light border rounded mb-3 mt-2">
                        <div class="single_input"><label>Transaction ID *</label><input type="text" wire:model="transaction_id"></div>
                        @error('transaction_id') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    @endif

                    <div class="terms mt-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model="agree_terms" id="agree">
                            <label class="form-check-label small" for="agree">Agree to terms & conditions.</label>
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