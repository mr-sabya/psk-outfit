@extends('frontend.layouts.app')

@section('content')
<!--=========================
        PAGE BANNER START
    ==========================-->
<section class="page_banner" data-bg="{{ url('assets/frontend/images/page_banner_bg.jpg') }}">
    <div class="page_banner_overlay">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="page_banner_text wow fadeInUp">
                        <h1>About Us</h1>
                        <ul>
                            <li><a href="#"><i class="fal fa-home-lg"></i> Home</a></li>
                            <li><a href="#">About</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--=========================
        PAGE BANNER START
    ==========================-->


<!--=========================
        ABOUT US PAGE START
    ==========================-->
<section class="about_us mt_100">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-xxl-5 col-md-10 col-lg-6 wow fadeInLeft">
                <div class="about_us_img">
                    <div class="img">
                        <img src="{{ url('assets/frontend/images/about_img.jpg') }}" alt="about us" class="img-fluid w-100">
                    </div>
                    <h3>12+ <span>Years experience</span></h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cupiditate
                        officiis architecto
                        reiciendis.
                        <span>jhon deo</span>
                    </p>
                </div>
            </div>
            <div class="col-xxl-6 col-lg-6 wow fadeInRight">
                <div class="about_us_text">
                    <h6>About Company</h6>
                    <h2>Well-coordinated Teamwork Speaks About Us</h2>
                    <p class="description">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Cupiditate
                        aspernatur molestiae
                        minima pariatur consequatur voluptate sapiente deleniti soluta.</p>
                    <ul>
                        <li>
                            <h4>trusted partner</h4>
                            <p>Lorem Ipsum Dolor Sit Amet Consectetur, Adipisicing Elit. Minus, Officiis Placeat
                                Iusto Quasi Adipisci Impedit Delectus Beatae Ab Maxime. Lorem Ipsum Dolor Sit Amet
                                Consectetur, Adipisicing Elit. </p>
                        </li>
                        <li>
                            <h4>quality products</h4>
                            <p>Lorem Ipsum Dolor Sit Amet Consectetur, Adipisicing Elit. Minus, Officiis Placeat
                                Iusto Quasi Adipisci Impedit Delectus Beatae Ab Maxime. Lorem Ipsum Dolor Sit Amet
                                Consectetur, </p>
                        </li>
                        <li>
                            <h4>first Delivery</h4>
                            <p>Lorem Ipsum Dolor Sit Amet Consectetur, Adipisicing Elit. Minus, Officiis Placeat
                                Iusto Quasi Adipisci Impedit Delectus Beatae Ab Maxime. Lorem Ipsum Dolor Sit Amet
                                Consectetur Adipisicing Elit Minus Officiis.</p>
                        </li>
                        <li>
                            <h4>secure payment</h4>
                            <p>Lorem Ipsum Dolor Sit Amet Consectetur, Adipisicing Elit. Minus, Officiis Placeat
                                Iusto Quasi Adipisci Impedit Delectus Beatae Ab Maxime. Lorem Ipsum Dolor Sit Amet
                                Consectetur</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<livewire:frontend.home.features />

<section class="about_choose mt_95 pt_100 pb_100">
    <div class="container">
        <div class="row">
            <div class="col-xxl-8 col-lg-7">
                <div class="about_choose_text">
                    <div class="row">
                        <div class="col-12">
                            <div class="section_heading_2 section_heading mb_15">
                                <h3>Why we are the <span>best</span></h3>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6 wow fadeInUp">
                            <div class="about_choose_text_box">
                                <span><i class="fal fa-tshirt"></i></span>
                                <h4>quality products</h4>
                                <p>Objectively pontificate quality models before intuitive information.</p>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6 wow fadeInUp">
                            <div class="about_choose_text_box">
                                <span><i class="fal fa-truck"></i></span>
                                <h4>Fast Delivery</h4>
                                <p>Objectively pontificate quality models before intuitive information.</p>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6 wow fadeInUp">
                            <div class="about_choose_text_box">
                                <span><i class="far fa-undo-alt"></i></span>
                                <h4>return policy</h4>
                                <p>Objectively pontificate quality models before intuitive information.</p>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6 wow fadeInUp">
                            <div class="about_choose_text_box">
                                <span><i class="fas fa-headset"></i></span>
                                <h4>24/7 Service</h4>
                                <p>Objectively pontificate quality models before intuitive information.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-4 col-lg-5 wow fadeInRight" data-wow-duration="1s"
                style="visibility: visible; animation-duration: 1s; animation-name: fadeInRight;">
                <div class="about_choose_img">
                    <img src="{{ url('assets/frontend/images/why_choose_img.jpg') }}" alt="about us" class="img-fluid w-100">
                </div>
            </div>
        </div>
    </div>
</section>

<livewire:frontend.home.brands />

<section class="about_video mt_100">
    <div class="container">
        <div class="row">
            <div class="col-12 wow fadeInUp">
                <div class="about_video_area">
                    <img src="{{ url('assets/frontend/images/about_video_bg.jpg') }}" alt="about video" class="img-fluid w-100">
                    <div class="overlay">
                        <a class="venobox play_btn" data-autoplay="true" data-vbtype="video"
                            href="https://youtu.be/nqye02H_H6I?si=Yq79QYJhfIT_wkC_">
                            <i class=" fas fa-play"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="counter_part mt_100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="counter_area">
                    <ul>
                        <li class="wow fadeInUp">
                            <div class="icon">
                                <img src="assets/images/counter_icon_1.png" alt="counter" class="img-fluid w-100">
                            </div>
                            <h2><span class="counter">950</span>+</h2>
                            <p>Happy customers</p>
                        </li>
                        <li class="wow fadeInUp">
                            <div class="icon">
                                <img src="assets/images/counter_icon_2.png" alt="counter" class="img-fluid w-100">
                            </div>
                            <h2><span class="counter">350</span>+</h2>
                            <p>Expert Team</p>
                        </li>
                        <li class="wow fadeInUp">
                            <div class="icon">
                                <img src="assets/images/counter_icon_3.png" alt="counter" class="img-fluid w-100">
                            </div>
                            <h2><span class="counter">35</span>+</h2>
                            <p>Award Wining</p>
                        </li>
                        <li class="wow fadeInUp">
                            <div class="icon">
                                <img src="assets/images/counter_icon_4.png" alt="counter" class="img-fluid w-100">
                            </div>
                            <h2><span class="counter">4.9</span></h2>
                            <p>Avarage Rating</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="mb-5">
    <livewire:frontend.home.blogs />
</div>
<!--=========================
        ABOUT US PAGE START
    ==========================-->

@endsection