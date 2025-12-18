<div class="mini_cart">
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel" wire:ignore.self>
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
                <li>
                    {{-- Product Image --}}
                    <a href="{{ route('product.show', $item->product->slug) }}" class="cart_img">
                        <img src="{{ $item->product->thumbnail_url ?? asset('assets/frontend/images/product_1.png') }}"
                            alt="{{ $item->product->name }}" class="img-fluid w-100">
                    </a>

                    <div class="cart_text">
                        {{-- Product Title --}}
                        <a class="cart_title" href="{{ route('product.show', $item->product->slug) }}">
                            {{ $item->product->name }}
                        </a>

                        {{-- Price and Quantity --}}
                        <p>
                            ৳{{ number_format($item->product->effective_price, 2) }}
                            <small class="text-secondary">x {{ $item->quantity }}</small>
                        </p>

                        {{-- Display Attributes (Color, Size, etc.) --}}
                        @if($item->options)
                        @foreach($item->options as $key => $value)
                        <span><b>{{ ucfirst($key) }}:</b> {{ $value }}</span>
                        @endforeach
                        @endif
                    </div>

                    {{-- Delete Button --}}
                    <a class="del_icon" href="javascript:void(0)"
                        wire:click="removeItem({{ $item->id }})"
                        wire:loading.attr="disabled">
                        <i class="fal fa-times"></i>
                    </a>
                </li>
                @endforeach
            </ul>

            <h5>sub total <span>৳{{ number_format($subtotal, 2) }}</span></h5>

            <div class="minicart_btn_area">
                <a class="common_btn" href="#">view cart</a>
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
</div>