@extends('frontend.layouts.app')

@section('content')

<!--=========================
        PAGE BANNER START
    ==========================-->
<livewire:frontend.components.page-banner :title="'Contact Us'" />
<!--=========================
        PAGE BANNER START
    ==========================-->


<!--============================
        CONTACT US START
    =============================-->
<section class="contact_us mt_75">
    <div class="container">
        <div class="row">
            <div class="col-xl-4 col-md-6">
                <div class="contact_info wow fadeInUp">
                    <span><img src="{{ url('assets/frontend/images/call_icon_black.png') }}" alt="call" class="img-fluid"></span>
                    <h3>Call Us</h3>
                    <a href="callto:{{ $settings['phone'] }}">{{ $settings['phone'] }}</a>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="contact_info wow fadeInUp">
                    <span><img src="{{ url('assets/frontend/images/mail_icon_black.png') }}" alt="Mail" class="img-fluid"></span>
                    <h3>Email Us</h3>
                    <a href="mailto:{{ $settings['email'] }}">{{ $settings['email'] }}</a>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="contact_info wow fadeInUp">
                    <span><img src="{{ url('assets/frontend/images/location_icon_black.png') }}" alt="Map" class="img-fluid"></span>
                    <h3>Our Location</h3>
                    <p>{{ $settings['address'] }}</p>
                </div>
            </div>
        </div>
        <div class="row mt_75">
            <div class="col-lg-5">
                <div class="contact_img wow fadeInLeft">
                    <img src="{{ url('assets/frontend/images/contact_message.jpg') }}" alt="contact" class="img-fluid w-100">
                    <div class="contact_hotline">
                        <h3>Hotline</h3>
                        <a href="callto:{{ $settings['phone'] }}">{{ $settings['phone'] }}</a>
                        <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="contact_form wow fadeInRight">
                    <h2>Get In Touch 👋</h2>
                    <form action="#">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="single_input">
                                    <label>name</label>
                                    <input type="text" placeholder="Jhon Deo">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="single_input">
                                    <label>email</label>
                                    <input type="email" placeholder="example@Zenis.com">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="single_input">
                                    <label>phone</label>
                                    <input type="text" placeholder="+96512344854475">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="single_input">
                                    <label>Subject</label>
                                    <input type="text" placeholder="Subject">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="single_input">
                                    <label>Message</label>
                                    <textarea rows="7" placeholder="Message..."></textarea>
                                </div>
                                <button class="common_btn">send message <i
                                        class="fas fa-long-arrow-right"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="contact_map mt_100 wow fadeInUp">
        {!! $settings['map'] !!}
    </div>
</section>
<!--============================
        CONTACT US END
    =============================-->
@endsection