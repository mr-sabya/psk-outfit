<section class="banner_2">
    <div class="container">
        <div class="row">
            <div class="col-xl-2  d-none d-xxl-block">
                <livewire:frontend.theme.menu-category />
            </div>
            <div class="col-xxl-7 col-lg-8">
                <div class="banner_content">
                    <div class="row banner_2_slider">
                        @forelse ($banners as $banner)
                        <div class="col-xl-12" wire:key="banner-{{ $banner->id }}">
                            <div class="banner_slider_2 wow fadeInUp"
                                data-bg="{{ url('storage/' . $banner->image) }}">

                                <div class="banner_slider_2_text">
                                    @if($banner->subtitle)
                                    <h3>{{ $banner->subtitle }}</h3>
                                    @endif

                                    <h1>{{ $banner->title }}</h1>

                                    <a class="common_btn" href="{{ $banner->link ?? '#' }}">
                                        {{ $banner->button }} <i class="fas fa-long-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @empty
                        {{-- Optional: Fallback if no banners are active --}}
                        <div class="col-xl-12">
                            <div class="banner_slider_2 wow fadeInUp" style="background-color: #eee;">
                                <div class="banner_slider_2_text">
                                    <h3>Welcome</h3>
                                    <h1>No Banners Configured</h1>
                                </div>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-lg-4 col-sm-12 col-md-12">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="banner_2_add wow fadeInUp"
                            data-bg="{{ url('assets/frontend/images/banner_3_add_bg_1.jpg') }}">
                            <div class="text">
                                <h4>Summer Offer</h4>
                                <h2>Make Your Fashion Story Unique Every Day</h2>
                                <a class="common_btn" href="shop_details.html">shop now <i
                                        class="fas fa-long-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>