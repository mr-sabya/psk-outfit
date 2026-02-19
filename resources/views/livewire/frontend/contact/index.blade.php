<section class="contact_us mt_75">
    <div class="container">
        <!-- Success/Error Alerts -->
        <div class="row">
            <div class="col-12">
                @if (session()->has('success'))
                <div class="alert alert-success" style="background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                    {{ session('success') }}
                </div>
                @endif
                @if (session()->has('error'))
                <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                    {{ session('error') }}
                </div>
                @endif
            </div>
        </div>

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
                            <!-- SVG kept same -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="contact_form wow fadeInRight">
                    <h2>Get In Touch 👋</h2>
                    <form wire:submit.prevent="sendMessage">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="single_input">
                                    <label>name</label>
                                    <input type="text" wire:model="name" placeholder="Jhon Deo">
                                    @error('name') <span class="text-danger" style="font-size: 12px; color: red;">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="single_input">
                                    <label>email</label>
                                    <input type="email" wire:model="email" placeholder="example@Zenis.com">
                                    @error('email') <span class="text-danger" style="font-size: 12px; color: red;">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="single_input">
                                    <label>phone</label>
                                    <input type="text" wire:model="phone" placeholder="+96512344854475">
                                    @error('phone') <span class="text-danger" style="font-size: 12px; color: red;">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="single_input">
                                    <label>Subject</label>
                                    <input type="text" wire:model="subject" placeholder="Subject">
                                    @error('subject') <span class="text-danger" style="font-size: 12px; color: red;">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="single_input">
                                    <label>Message</label>
                                    <textarea rows="7" wire:model="message" placeholder="Message..."></textarea>
                                    @error('message') <span class="text-danger" style="font-size: 12px; color: red;">{{ $message }}</span> @enderror
                                </div>
                                <button type="submit" class="common_btn" wire:loading.attr="disabled">
                                    <span wire:loading.remove>send message <i class="fas fa-long-arrow-right"></i></span>
                                    <span wire:loading>Sending...</span>
                                </button>
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