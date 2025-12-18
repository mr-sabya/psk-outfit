<li>
    <a href="javascript:void(0);"
        data-bs-toggle="offcanvas"
        data-bs-target="#offcanvasRight"
        aria-controls="offcanvasRight"
        class="position-relative">
        <b>
            <img src="{{ asset('assets/frontend/images/cart_black.svg') }}" alt="cart" class="img-fluid">
        </b>
        {{-- Show the badge only if count is greater than 0 --}}
        @if($count > 0)
        <span>{{ $count }}</span>
        @else
        <span>0</span>
        @endif
    </a>
</li>