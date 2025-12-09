<section class="flash_sell_2 flash_sell mt_95">
    @if($deal && $deal->products->isNotEmpty())
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xxl-6 col-md-3 col-xl-4">
                <div class="section_heading_2 section_heading">
                    {{-- Display the Deal Name or default to Flash Sell --}}
                    <h3><span>{{ Str::before($deal->name, ' ') }}</span> {{ Str::after($deal->name, ' ') }}</h3>
                </div>
            </div>

            <div class="col-xxl-6 col-md-9 col-xl-8">
                <div class="d-flex flex-wrap justify-content-end">
                    {{--
                            COUNTDOWN:
                            We pass the date via a data attribute. 
                            Ensure your theme's main.js reads 'data-countdown' or similar to initialize the timer.
                            We use wire:ignore so Livewire doesn't refresh this div and break the JS timer.
                        --}}
                    <div class="simply-countdown simply-countdown-one"
                        wire:ignore
                        data-countdown="{{ \Carbon\Carbon::parse($deal->end_date)->format('Y/m/d H:i:s') }}">
                    </div>

                    <div class="view_all_btn_area">
                        <a class="view_all_btn" href="#">View all</a>
                    </div>
                </div>
            </div>
        </div>

        {{--
                SLIDER:
                The class 'flash_sell_2_slider' likely initializes a Slick/Owl carousel.
                We use wire:ignore so Livewire doesn't break the slider functionality after load.
            --}}
        <div class="row mt_25 flash_sell_2_slider" wire:ignore>
            @foreach($deal->products as $product)
            <div class="col-xl-1-5 wow fadeInUp">
                <livewire:frontend.components.product
                    :product="$product"
                    :wire:key="'flash-deal-'.$deal->id.'-prod-'.$product->id" />
            </div>
            @endforeach
        </div>
    </div>
    @endif
</section>