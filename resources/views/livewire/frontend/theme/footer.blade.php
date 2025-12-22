<footer class="footer_2 pt_100" data-bg="{{ url('assets/frontend/images/footer_2_bg_2.jpg') }}">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-xl-3 col-md-6 col-lg-3 wow fadeInUp" data-wow-delay=".7s">
                <div class="footer_2_logo_area">
                    <a class="footer_logo" href="index.html">
                        <img src="{{ isset($settings['white_logo']) && $settings['white_logo'] ? asset('storage/' . $settings['white_logo']) : asset('assets/frontend/images/footer_logo_2.png') }}" alt="Zenis" class="img-fluid w-100" />

                    </a>
                    <p>
                        {{ isset($settings['footer_about']) && $settings['footer_about'] ? $settings['footer_about'] : 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi, distinctio molestiae error ullam obcaecati dolorem inventore.' }}
                    </p>

                    <ul>
                        <li><span>Follow :</span></li>
                        @if(!empty($settings['facebook']))
                        <li><a href="{{ $settings['facebook'] }}" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook-f"></i></a></li>
                        @endif

                        @if(!empty($settings['instagram']))
                        <li><a href="{{ $settings['instagram'] }}" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram"></i></a></li>
                        @endif

                        @if(!empty($settings['twitter']))
                        <li><a href="{{ $settings['twitter'] }}" target="_blank" rel="noopener noreferrer"><i class="fab fa-twitter"></i></a></li>
                        @endif

                        @if(!empty($settings['youtube']))
                        <li><a href="{{ $settings['youtube'] }}" target="_blank" rel="noopener noreferrer"><i class="fab fa-youtube"></i></a></li>
                        @endif

                        @if(!empty($settings['linkedin']))
                        <li><a href="{{ $settings['linkedin'] }}" target="_blank" rel="noopener noreferrer"><i class="fab fa-linkedin-in"></i></a></li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-xl-2 col-sm-6 col-md-4 col-lg-2 wow fadeInUp" data-wow-delay="1s">
                <div class="footer_link">
                    <h3>Company</h3>
                    <ul>
                        <li><a href="{{ route('about') }}" wire:navigate>About us</a></li>
                        <li><a href="{{ route('contact') }}" wire:navigate>Contact Us</a></li>
                        <li><a href="#">Affiliate</a></li>
                        <li><a href="#">Career</a></li>
                        <li><a href="{{ route('blog') }}" wire:navigate>Latest News</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-2 col-sm-6 col-md-4 col-lg-2 wow fadeInUp" data-wow-delay="1.3s">
                <div class="footer_link">
                    <h3>Category</h3>
                    <ul>
                        @foreach($categories as $category)
                        <li><a href="{{ route('shop', ['category' => $category->slug]) }}" wire:navigate>{{ $category->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-xl-2 col-sm-6 col-md-4 col-lg-2 wow fadeInUp" data-wow-delay="1.6s">
                <div class="footer_link">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="{{ route('page.show', ['slug' => 'privacy-policy']) }}" wire:navigate>Privacy Ploicy</a></li>
                        <li><a href="{{ route('page.show', ['slug' => 'terms-and-conditions']) }}" wire:navigate>Terms and Condition</a></li>
                        <li><a href="{{ route('page.show', ['slug' => 'return-exchange-policy']) }}" wire:navigate>Return Policy</a></li>
                        <li><a href="{{ route('page.show', ['slug' => 'faq']) }}">FAQ's</a></li>
                        <li><a href="#">Become a Vendor</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-md-4 col-lg-3 wow fadeInUp" data-wow-delay="1.9s">
                <div class="footer_link footer_logo_area">
                    <h3>Contact Us</h3>
                    <p>
                        {{ isset($settings['footer_contact_text']) && $settings['footer_contact_text'] 
        ? $settings['footer_contact_text']
        : 'It is a long established fact that a reader is distracted looking at the layout. It is a long established fact.'
    }}
                    </p>

                    <span>
                        <b><img src="{{ asset('assets/frontend/images/location_icon_white.png') }}" alt="Map" class="img-fluid"></b>
                        {{ $settings['address'] ?? '37 W 24th St, New York, NY' }}
                    </span>

                    <span>
                        <b><img src="{{ asset('assets/frontend/images/phone_icon_white.png') }}" alt="Call" class="img-fluid"></b>
                        <a href="tel:{{ $settings['phone'] ?? '+123324587939' }}">
                            {{ $settings['phone'] ?? '+123 324 5879 39' }}
                        </a>
                    </span>

                    <span>
                        <b><img src="{{ asset('assets/frontend/images/mail_icon_white.png') }}" alt="Mail" class="img-fluid"></b>
                        <a href="mailto:{{ $settings['email'] ?? 'info@Zenis.com' }}">
                            {{ $settings['email'] ?? 'info@Zenis.com' }}
                        </a>
                    </span>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="footer_copyright mt_75">
                    <p>{!! $settings['copyright'] ?? 'Copyright @ <b>Website</b> {{ $currentYear }}. All right reserved.' !!}</p>
                    <ul class="payment">
                        <li>Payment by :</li>
                        <li>
                            <img src="{{ url('assets/frontend/images/footer_payment_icon_1.jpg') }}" alt="payment"
                                class="img-fluid w-100">
                        </li>
                        <li>
                            <img src="{{ url('assets/frontend/images/footer_payment_icon_2.jpg') }}" alt="payment"
                                class="img-fluid w-100">
                        </li>
                        <li>
                            <img src="{{ url('assets/frontend/images/footer_payment_icon_3.jpg') }}" alt="payment"
                                class="img-fluid w-100">
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>