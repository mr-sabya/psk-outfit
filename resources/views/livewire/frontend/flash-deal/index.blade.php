<section class="flash_deals mt_100 mb_100">
    <div class="container">
        @forelse($deals as $deal)
        <!-- Deal Heading & Countdown -->
        <div class="row {{ !$loop->first ? 'mt_50' : '' }}">
            <div class="col-12">
                <div class="falsh_deals_heading">
                    <h3>{{ $deal->name }}</h3>
                    {{--
                            We use a unique ID for each countdown 
                            and pass the expiry date via data attribute 
                        --}}
                    <div class="simply-countdown deal-countdown"
                        id="deal-{{ $deal->id }}"
                        data-date="{{ $deal->expires_at->format('Y-m-d H:i:s') }}"
                        wire:ignore>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products for this Deal -->
        <div class="row">
            @foreach($deal->products as $product)
            <div class="col-xl-1-5 col-6 col-md-4 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                <div class="product_item_2 product_item">
                    <div class="product_img">
                        <img src="{{ $product->thumb_image_url ?? url('assets/frontend/images/product_7.png') }}" alt="{{ $product->name }}" class="img-fluid w-100">

                        {{-- Calculate Discount Badge --}}
                        @if($product->offer_price > 0)
                        <ul class="discount_list">
                            @php
                            $discount = (($product->price - $product->offer_price) / $product->price) * 100;
                            @endphp
                            <li class="discount"> <b>-</b> {{ round($discount) }}%</li>
                        </ul>
                        @endif

                        <ul class="btn_list">
                            <li><a href="javascript:void(0)"><img src="{{ url('assets/frontend/images/compare_icon_white.svg') }}" alt="Compare"></a></li>
                            <li><a href="javascript:void(0)"><img src="{{ url('assets/frontend/images/love_icon_white.svg') }}" alt="Love"></a></li>
                            <li><a href="javascript:void(0)"><img src="{{ url('assets/frontend/images/cart_icon_white.svg') }}" alt="Cart"></a></li>
                        </ul>
                    </div>
                    <div class="product_text">
                        <a class="title" href="#">{{ $product->name }}</a>

                        @if($product->offer_price > 0)
                        <p class="price">${{ number_format($product->offer_price, 2) }} <del>${{ number_format($product->price, 2) }}</del></p>
                        @else
                        <p class="price">${{ number_format($product->price, 2) }}</p>
                        @endif

                        <p class="rating">
                            @for($i=1; $i<=5; $i++)
                                <i class="{{ $i <= $product->reviews_avg_rating ? 'fas' : 'far' }} fa-star"></i>
                                @endfor
                                <span>({{ $product->reviews_count }} reviews)</span>
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @empty
        <div class="row">
            <div class="col-12 text-center">
                <h4>No Active Deals Found</h4>
            </div>
        </div>
        @endforelse

        <!-- Pagination -->
        <div class="row">
            <div class="pagination_area">
                <nav aria-label="Page navigation">
                    {{ $deals->links() }}
                </nav>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Function to initialize countdowns
    function initCountdowns() {
        $('.deal-countdown').each(function() {
            let element = $(this);
            let date = new Date(element.data('date'));

            // Check if simplyCountdown is available (based on your template's JS)
            if (typeof simplyCountdown === 'function') {
                simplyCountdown('#' + element.attr('id'), {
                    year: date.getFullYear(),
                    month: date.getMonth() + 1,
                    day: date.getDate(),
                    hours: date.getHours(),
                    minutes: date.getMinutes(),
                    seconds: date.getSeconds(),
                    enableUtc: false
                });
            }
        });
    }

    // Initialize on load
    document.addEventListener('livewire:navigated', () => {
        initCountdowns();
    });
</script>
@endpush