<section class="page_banner" data-bg="{{ url('assets/frontend/images/page_banner_bg.jpg') }}">
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