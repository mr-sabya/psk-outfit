<div>
    {{-- 1. About Us Section --}}
    @if($about)
    <section class="about_us mt_100">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-xxl-5 col-md-10 col-lg-6 wow fadeInLeft">
                    <div class="about_us_img">
                        <div class="img">
                            <img src="{{ asset($about->image) }}" alt="about us" class="img-fluid w-100">
                        </div>
                        <h3>{{ $about->experience_year }}+ <span>Years experience</span></h3>
                        <p>{{ $about->experience_text }}
                            <span>{{ $about->author_name }}</span>
                        </p>
                    </div>
                </div>
                <div class="col-xxl-6 col-lg-6 wow fadeInRight">
                    <div class="about_us_text">
                        <h6>{{ $about->sub_title }}</h6>
                        <h2>{{ $about->title }}</h2>
                        <p class="description">{{ $about->description }}</p>
                        <ul>
                            @if(!empty($about->features))
                            @foreach($about->features as $feature)
                            <li>
                                <h4>{{ $feature['title'] }}</h4>
                                <p>{{ $feature['description'] }}</p>
                            </li>
                            @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- 2. Why Choose Us Section (Added for a complete page) --}}
    @if($whyChoose)
    <section class="about_choose mt_95 pt_100 pb_100">
        <div class="container">
            <div class="row">
                <div class="col-xxl-8 col-lg-7">
                    <div class="about_choose_text">
                        <div class="row">
                            <div class="col-12">
                                <div class="section_heading_2 section_heading mb_15">
                                    <h3>{!! $whyChoose->title !!}</h3>
                                </div>
                            </div>
                            @foreach($whyChoose->items as $item)
                            <div class="col-xl-6 col-md-6 wow fadeInUp">
                                <div class="about_choose_text_box">
                                    <span><i class="{{ $item['icon'] }}"></i></span>
                                    <h4>{{ $item['title'] }}</h4>
                                    <p>{{ $item['description'] }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-lg-5 wow fadeInRight">
                    <div class="about_choose_img">
                        <img src="{{ asset($whyChoose->image) }}" alt="why choose" class="img-fluid w-100">
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- 3. Counter Section (Added for a complete page) --}}
    @if($counter)
    <section class="counter_part mt_100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="counter_area">
                        <ul>
                            @foreach($counter->items as $item)
                            <li class="wow fadeInUp">
                                <div class="icon">
                                    <img src="{{ asset($item['icon']) }}" alt="counter" class="img-fluid w-100">
                                </div>
                                <h2><span class="counter">{{ $item['number'] }}</span>{{ $item['suffix'] }}</h2>
                                <p>{{ $item['title'] }}</p>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
</div>