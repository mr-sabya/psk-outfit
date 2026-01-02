<div wire:key="minicart-wrapper">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">
            my cart <span>({{ sprintf('%02d', $count) }})</span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
            <i class="far fa-times"></i>
        </button>
    </div>

    <div class="offcanvas-body">
        @if(count($cartItems) > 0)
        <ul>
            @foreach($cartItems as $item)
            <li class="align-items-start">
                {{-- Product Image --}}
                <a href="{{ route('product.show', $item->product->slug) }}" class="cart_img">
                    <img src="{{ $item->product->thumbnail_url ?? asset('assets/frontend/images/product_1.png') }}"
                        alt="{{ $item->product->name }}" class="img-fluid w-100">
                </a>

                <div class="cart_text">
                    {{-- Product Title --}}
                    <a class="cart_title" href="{{ route('product.show', $item->product->slug) }}">
                        {{ Str::limit($item->product->name, 25) }}
                    </a>

                    {{-- Price --}}
                    <p>৳{{ number_format($item->product->effective_price, 2) }}</p>

                    {{-- QUANTITY CONTROLS --}}
                    <div class="minicart_quantity_area d-flex align-items-center mt-1">
                        <button type="button" wire:click="decrementQuantity({{ $item->id }})" class="qty_btn">
                            <i class="fal fa-minus"></i>
                        </button>
                        <span class="qty_value mx-2 fw-bold">{{ $item->quantity }}</span>
                        <button type="button" wire:click="incrementQuantity({{ $item->id }})" class="qty_btn">
                            <i class="fal fa-plus"></i>
                        </button>
                    </div>

                    {{-- Display Attributes --}}
                    @if($item->options)
                    <div class="mt-1">
                        @foreach($item->options as $key => $value)
                        <span class="d-block small text-muted" style="font-size: 11px; line-height: 1.2;">
                            <b>{{ ucfirst($key) }}:</b> {{ $value }}
                        </span>
                        @endforeach
                    </div>
                    @endif
                </div>

                {{-- DELETE BUTTON (TRASH ICON) --}}
                <a class="del_icon text-danger" href="javascript:void(0)"
                    wire:click="removeItem({{ $item->id }})"
                    wire:loading.attr="disabled">
                    <i class="fal fa-trash-alt"></i>
                </a>
            </li>
            @endforeach
        </ul>

        <h5>sub total <span>৳{{ number_format($subtotal, 2) }}</span></h5>

        <div class="minicart_btn_area">
            <a class="common_btn" href="{{ route('user.cart') }}" wire:navigate>view cart</a>
        </div>
        @else
        {{-- Empty State --}}
        <div class="text-center py-5">
            <i class="fal fa-shopping-bag fa-3x mb-3 text-muted"></i>
            <p>Your cart is empty</p>
            <div class="minicart_btn_area mt-3">
                <a class="common_btn" href="{{ route('shop') }}">Go to Shop</a>
            </div>
        </div>
        @endif
    </div>
</div>