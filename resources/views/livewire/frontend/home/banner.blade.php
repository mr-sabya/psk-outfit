<section class="banner_2">
    <div class="container">
        <div class="row">

            <div class="col-xxl-12 col-lg-12">
                <div class="banner_content">
                    <div class="banner_2_slider">
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

        </div>
    </div>
</section>