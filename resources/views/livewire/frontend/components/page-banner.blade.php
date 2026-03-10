<section class="page_banner"
    @if(!empty($settings['banner_background']))
    data-bg="{{ url('storage/' . $settings['banner_background']) }}"
    @endif>
    <div class="page_banner_overlay">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="page_banner_text wow fadeInUp">
                        <h1>{{ $title }}</h1>
                        <ul>
                            <li><a href="{{ route('home') }}" wire:navigate><i class="fal fa-home-lg"></i> Home</a></li>
                            <li class="text-white">{{ $title }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>