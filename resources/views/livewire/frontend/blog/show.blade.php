<section class="blog_details blog_2 mt_75 mb_100">
    <div class="container">
        <div class="row">
            <div class="col-xl-9 col-lg-8 wow fadeInUp">
                <div class="blog_details_left">
                    <!-- Main Image -->
                    <div class="blog_details_img_1">
                        <img src="{{ $post->image_url ?? url('assets/frontend/images/blog_details_1_img.jpg') }}"
                            alt="{{ $post->title }}" class="img-fluid w-100">
                    </div>

                    <!-- Meta Info -->
                    <ul class="blog_details_top d-flex flex-wrap">
                        <li>
                            <span><img src="{{ url('assets/frontend/images/calender.png') }}" alt="icon" class="img-fluid w-100"></span>
                            {{ $post->published_at->format('M d, Y') }}
                        </li>
                        <li>
                            <span><img src="{{ url('assets/frontend/images/user_icon_black.svg') }}" alt="icon" class="img-fluid w-100"></span>
                            By Admin
                        </li>
                        <li>
                            <span><img src="{{ url('assets/frontend/images/massage.png') }}" alt="icon" class="img-fluid w-100"></span>
                            0 Comments
                        </li>
                    </ul>

                    <!-- Title -->
                    <h2>{{ $post->title }}</h2>

                    <!-- Full Content -->
                    <div class="blog_post_description">
                        {!! $post->content !!}
                    </div>

                    <!-- If you have specific content sections, use excerpt here -->
                    @if($post->excerpt)
                    <div class="blog_details_review">
                        <p>"{{ $post->excerpt }}"</p>
                    </div>
                    @endif
                </div>

                <!-- Tags and Social Share -->
                <div class="blog_shear_area">
                    <div class="row">
                        <div class="col-xl-7">
                            <div class="blog_shear_area_left d-flex flex-wrap">
                                <h5>Post Tags:</h5>
                                <ul class="blog_details_tag d-flex flex-wrap">
                                    @foreach($post->tags as $tag)
                                    <li><a href="#">{{ $tag->name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-5">
                            <div class="blog_shear_area_right d-flex flex-wrap">
                                <h5>Share:</h5>
                                <ul class="d-flex flex-wrap">
                                    {{-- Corrected helper: url()->current() --}}
                                    <li>
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}" target="_blank">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}" target="_blank">
                                            <i class="fab fa-linkedin-in"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}&media={{ urlencode($post->image_url) }}" target="_blank">
                                            <i class="fab fa-pinterest"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Static Comments Section (Update this when you create a Comment model) -->
                <div class="blog_details_comment">
                    <h2>0 Comments</h2>
                    <!-- Comment list logic goes here -->
                </div>

                <!-- Comment Input Form -->
                <div class="blog_details_comment_input">
                    <form action="#">
                        <h2>Leave a Comment</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="blog_form_input">
                                    <input type="text" placeholder="Name *">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="blog_form_input">
                                    <input type="email" placeholder="E-mail *">
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="blog_form_input">
                                    <textarea rows="6" placeholder="Your Comment Here..."></textarea>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <button type="button" class="common_btn">Submit Comment <i class="fas fa-long-arrow-right"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sidebar Component -->
            <div class="col-xl-3 col-lg-4 col-md-8 wow fadeInRight">
                <livewire:frontend.blog.sidebar />
            </div>
        </div>
    </div>
</section>