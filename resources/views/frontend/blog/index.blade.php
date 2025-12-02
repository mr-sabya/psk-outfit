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
                        <h1>Blog Right Sidebar</h1>
                        <ul>
                            <li><a href="#"><i class="fal fa-home-lg"></i> Home</a></li>
                            <li><a href="#">Blog Right Sidebar</a></li>
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


<!--============================
        BLOG RIGHT SIDEBAR START
    =============================-->
<section class="blog_right_sidebar blog_2 mt_75 mb_100">
    <div class="container">
        <div class="row">
            <div class="col-xl-9 col-lg-8">
                <div class="row">
                    <div class="col-xl-4 col-md-6 wow fadeInUp">
                        <div class="blog_item">
                            <a href="blog_details.html" class="blog_img">
                                <img src="{{ url('assets/frontend/images/blog_img_12.png') }}" alt="blog" class="img-fluid w-100">
                            </a>
                            <div class="blog_text">
                                <ul class="top">
                                    <li>
                                        <span>
                                            <img src="{{ url('assets/frontend/images/user_icon_black.svg') }}" alt="user"
                                                class="img-fluid w-100">
                                        </span>
                                        Jhon Deo
                                    </li>
                                    <li>
                                        <span>
                                            <img src="{{ url('assets/frontend/images/calender.png') }}" alt="Message"
                                                class="img-fluid w-100">
                                        </span>
                                        24 Apr 2025
                                    </li>
                                </ul>
                                <a class="title" href="blog_details.html">How To Choose The Right Sofa for your
                                    home</a>
                                <ul class="bottom">
                                    <li><a href="blog_details.html">read more <i
                                                class="fas fa-long-arrow-right"></i></a>
                                    <li><span><i class="far fa-comment-dots"></i> 15 Comments</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 wow fadeInUp">
                        <div class="blog_item">
                            <a href="blog_classic.html" class="blog_img">
                                <img src="{{ url('assets/frontend/images/blog_img_5.png') }}" alt="blog" class="img-fluid w-100">
                            </a>
                            <div class="blog_text">
                                <ul class="top">
                                    <li>
                                        <span>
                                            <img src="{{ url('assets/frontend/images/user_icon_black.svg') }}" alt="user"
                                                class="img-fluid w-100">
                                        </span>
                                        Adnan Alvi
                                    </li>
                                    <li>
                                        <span>
                                            <img src="{{ url('assets/frontend/images/calender.png') }}" alt="Message"
                                                class="img-fluid w-100">
                                        </span>
                                        12 Mar 2025
                                    </li>
                                </ul>
                                <a class="title" href="blog_classic.html">How to Plop Hair for Bouncy, Beautiful
                                    Curls</a>
                                <ul class="bottom">
                                    <li><a href="blog_details.html">read more <i
                                                class="fas fa-long-arrow-right"></i></a>
                                    <li><span><i class="far fa-comment-dots"></i> 15 Comments</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 wow fadeInUp">
                        <div class="blog_item">
                            <a href="blog_classic.html" class="blog_img">
                                <img src="{{ url('assets/frontend/images/blog_img_1.png') }}" alt="blog" class="img-fluid w-100">
                            </a>
                            <div class="blog_text">
                                <ul class="top">
                                    <li>
                                        <span>
                                            <img src="{{ url('assets/frontend/images/user_icon_black.svg') }}" alt="user"
                                                class="img-fluid w-100">
                                        </span>
                                        Adnan Alvi
                                    </li>
                                    <li>
                                        <span>
                                            <img src="{{ url('assets/frontend/images/calender.png') }}" alt="Message"
                                                class="img-fluid w-100">
                                        </span>
                                        12 Mar 2025
                                    </li>
                                </ul>
                                <a class="title" href="blog_classic.html">How to Plop Hair for Bouncy, Beautiful
                                    Curls</a>
                                <ul class="bottom">
                                    <li><a href="blog_details.html">read more <i
                                                class="fas fa-long-arrow-right"></i></a>
                                    <li><span><i class="far fa-comment-dots"></i> 15 Comments</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 wow fadeInUp">
                        <div class="blog_item">
                            <a href="blog_details.html" class="blog_img">
                                <img src="{{ url('assets/frontend/images/blog_img_6.png') }}" alt="blog" class="img-fluid w-100">
                            </a>
                            <div class="blog_text">
                                <ul class="top">
                                    <li>
                                        <span>
                                            <img src="{{ url('assets/frontend/images/user_icon_black.svg') }}" alt="user"
                                                class="img-fluid w-100">
                                        </span>
                                        Hasib Sing
                                    </li>
                                    <li>
                                        <span>
                                            <img src="{{ url('assets/frontend/images/calender.png') }}" alt="Message"
                                                class="img-fluid w-100">
                                        </span>
                                        20 Apr 2025
                                    </li>
                                </ul>
                                <a class="title" href="blog_details.html">Fast fashion: How clothes are linked to
                                    climate change</a>
                                <ul class="bottom">
                                    <li><a href="blog_details.html">read more <i
                                                class="fas fa-long-arrow-right"></i></a>
                                    <li><span><i class="far fa-comment-dots"></i> 42 Comments</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 wow fadeInUp">
                        <div class="blog_item">
                            <a href="blog_details.html" class="blog_img">
                                <img src="{{ url('assets/frontend/images/blog_img_2.png') }}" alt="blog" class="img-fluid w-100">
                            </a>
                            <div class="blog_text">
                                <ul class="top">
                                    <li>
                                        <span>
                                            <img src="{{ url('assets/frontend/images/user_icon_black.svg') }}" alt="user"
                                                class="img-fluid w-100">
                                        </span>
                                        Hasib Sing
                                    </li>
                                    <li>
                                        <span>
                                            <img src="{{ url('assets/frontend/images/calender.png') }}" alt="Message"
                                                class="img-fluid w-100">
                                        </span>
                                        20 Apr 2025
                                    </li>
                                </ul>
                                <a class="title" href="blog_details.html">Fast fashion: How clothes are linked to
                                    climate change</a>
                                <ul class="bottom">
                                    <li><a href="blog_details.html">read more <i
                                                class="fas fa-long-arrow-right"></i></a>
                                    <li><span><i class="far fa-comment-dots"></i> 42 Comments</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 wow fadeInUp">
                        <div class="blog_item">
                            <a href="blog_details.html" class="blog_img">
                                <img src="{{ url('assets/frontend/images/blog_img_3.png') }}" alt="blog" class="img-fluid w-100">
                            </a>
                            <div class="blog_text">
                                <ul class="top">
                                    <li>
                                        <span>
                                            <img src="{{ url('assets/frontend/images/user_icon_black.svg') }}" alt="user"
                                                class="img-fluid w-100">
                                        </span>
                                        Smith Jhon
                                    </li>
                                    <li>
                                        <span>
                                            <img src="{{ url('assets/frontend/images/calender.png') }}" alt="Message"
                                                class="img-fluid w-100">
                                        </span>
                                        07 Mar 2025
                                    </li>
                                </ul>
                                <a class="title" href="blog_details.html">Which foundation formula is right for your
                                    skin?</a>
                                <ul class="bottom">
                                    <li><a href="blog_details.html">read more <i
                                                class="fas fa-long-arrow-right"></i></a>
                                    <li><span><i class="far fa-comment-dots"></i> 36 Comments</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 wow fadeInUp">
                        <div class="blog_item">
                            <a href="blog_details.html" class="blog_img">
                                <img src="{{ url('assets/frontend/images/blog_img_4.png') }}" alt="blog" class="img-fluid w-100">
                            </a>
                            <div class="blog_text">
                                <ul class="top">
                                    <li>
                                        <span>
                                            <img src="{{ url('assets/frontend/images/user_icon_black.svg') }}" alt="user"
                                                class="img-fluid w-100">
                                        </span>
                                        Jhon Deo
                                    </li>
                                    <li>
                                        <span>
                                            <img src="{{ url('assets/frontend/images/calender.png') }}" alt="Message"
                                                class="img-fluid w-100">
                                        </span>
                                        24 Apr 2025
                                    </li>
                                </ul>
                                <a class="title" href="blog_details.html">How To Choose The Right Sofa for your
                                    home</a>
                                <ul class="bottom">
                                    <li><a href="blog_details.html">read more <i
                                                class="fas fa-long-arrow-right"></i></a>
                                    <li><span><i class="far fa-comment-dots"></i> 15 Comments</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 wow fadeInUp">
                        <div class="blog_item">
                            <a href="blog_details.html" class="blog_img">
                                <img src="{{ url('assets/frontend/images/blog_img_7.png') }}" alt="blog" class="img-fluid w-100">
                            </a>
                            <div class="blog_text">
                                <ul class="top">
                                    <li>
                                        <span>
                                            <img src="{{ url('assets/frontend/images/user_icon_black.svg') }}" alt="user"
                                                class="img-fluid w-100">
                                        </span>
                                        Smith Jhon
                                    </li>
                                    <li>
                                        <span>
                                            <img src="{{ url('assets/frontend/images/calender.png') }}" alt="Message"
                                                class="img-fluid w-100">
                                        </span>
                                        07 Mar 2025
                                    </li>
                                </ul>
                                <a class="title" href="blog_details.html">Which foundation formula is right for your
                                    skin?</a>
                                <ul class="bottom">
                                    <li><a href="blog_details.html">read more <i
                                                class="fas fa-long-arrow-right"></i></a>
                                    <li><span><i class="far fa-comment-dots"></i> 36 Comments</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 wow fadeInUp">
                        <div class="blog_item">
                            <a href="blog_details.html" class="blog_img">
                                <img src="{{ url('assets/frontend/images/blog_img_8.png') }}" alt="blog" class="img-fluid w-100">
                            </a>
                            <div class="blog_text">
                                <ul class="top">
                                    <li>
                                        <span>
                                            <img src="{{ url('assets/frontend/images/user_icon_black.svg') }}" alt="user"
                                                class="img-fluid w-100">
                                        </span>
                                        Jhon Deo
                                    </li>
                                    <li>
                                        <span>
                                            <img src="{{ url('assets/frontend/images/calender.png') }}" alt="Message"
                                                class="img-fluid w-100">
                                        </span>
                                        24 Apr 2025
                                    </li>
                                </ul>
                                <a class="title" href="blog_details.html">How To Choose The Right Sofa for your
                                    home</a>
                                <ul class="bottom">
                                    <li><a href="blog_details.html">read more <i
                                                class="fas fa-long-arrow-right"></i></a>
                                    <li><span><i class="far fa-comment-dots"></i> 15 Comments</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 wow fadeInUp">
                        <div class="blog_item">
                            <a href="blog_details.html" class="blog_img">
                                <img src="{{ url('assets/frontend/images/blog_img_9.png') }}" alt="blog" class="img-fluid w-100">
                            </a>
                            <div class="blog_text">
                                <ul class="top">
                                    <li>
                                        <span>
                                            <img src="{{ url('assets/frontend/images/user_icon_black.svg') }}" alt="user"
                                                class="img-fluid w-100">
                                        </span>
                                        Adnan Alvi
                                    </li>
                                    <li>
                                        <span>
                                            <img src="{{ url('assets/frontend/images/calender.png') }}" alt="Message"
                                                class="img-fluid w-100">
                                        </span>
                                        12 Mar 2025
                                    </li>
                                </ul>
                                <a class="title" href="blog_details.html">How to Plop Hair for Bouncy, Beautiful
                                    Curls</a>
                                <ul class="bottom">
                                    <li><a href="blog_details.html">read more <i
                                                class="fas fa-long-arrow-right"></i></a>
                                    <li><span><i class="far fa-comment-dots"></i> 15 Comments</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 wow fadeInUp">
                        <div class="blog_item">
                            <a href="blog_details.html" class="blog_img">
                                <img src="{{ url('assets/frontend/images/blog_img_10.png') }}" alt="blog" class="img-fluid w-100">
                            </a>
                            <div class="blog_text">
                                <ul class="top">
                                    <li>
                                        <span>
                                            <img src="{{ url('assets/frontend/images/user_icon_black.svg') }}" alt="user"
                                                class="img-fluid w-100">
                                        </span>
                                        Hasib Sing
                                    </li>
                                    <li>
                                        <span>
                                            <img src="{{ url('assets/frontend/images/calender.png') }}" alt="Message"
                                                class="img-fluid w-100">
                                        </span>
                                        20 Apr 2025
                                    </li>
                                </ul>
                                <a class="title" href="blog_details.html">Fast fashion: How clothes are linked to
                                    climate change</a>
                                <ul class="bottom">
                                    <li><a href="blog_details.html">read more <i
                                                class="fas fa-long-arrow-right"></i></a>
                                    <li><span><i class="far fa-comment-dots"></i> 42 Comments</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 wow fadeInUp">
                        <div class="blog_item">
                            <a href="blog_details.html" class="blog_img">
                                <img src="{{ url('assets/frontend/images/blog_img_11.png') }}" alt="blog" class="img-fluid w-100">
                            </a>
                            <div class="blog_text">
                                <ul class="top">
                                    <li>
                                        <span>
                                            <img src="{{ url('assets/frontend/images/user_icon_black.svg') }}" alt="user"
                                                class="img-fluid w-100">
                                        </span>
                                        Smith Jhon
                                    </li>
                                    <li>
                                        <span>
                                            <img src="{{ url('assets/frontend/images/calender.png') }}" alt="Message"
                                                class="img-fluid w-100">
                                        </span>
                                        07 Mar 2025
                                    </li>
                                </ul>
                                <a class="title" href="blog_details.html">Which foundation formula is right for your
                                    skin?</a>
                                <ul class="bottom">
                                    <li><a href="blog_details.html">read more <i
                                                class="fas fa-long-arrow-right"></i></a>
                                    <li><span><i class="far fa-comment-dots"></i> 36 Comments</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="pagination_area">
                        <nav aria-label="...">
                            <ul class="pagination justify-content-center mt_50">
                                <li class="page-item">
                                    <a class="page-link" href="#">
                                        <i class="far fa-arrow-left"></i>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link active" href="#">01</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">02</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">03</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">
                                        <i class="far fa-arrow-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-8">
                <div id="sticky_sidebar">
                    <div class="blog_details_right wow fadeInRight">
                        <form action="#">
                            <input type="text" placeholder="Search...">
                            <button type="submit"><i class="far fa-search" aria-hidden="true"></i></button>
                        </form>
                        <div class="blog_details_right_header sidebar_blog">
                            <h3>Popular Blog</h3>
                            <div class="popular_blog d-flex flex-wrap">
                                <div class="popular_blog_img">
                                    <img src="{{ url('assets/frontend/images/blog_img_1.png') }}" alt="img" class="img-fluid w-100">
                                </div>
                                <div class="popular_blog_text">
                                    <p>
                                        <span><img src="{{ url('assets/frontend/images/calender.png') }}" alt="icon"
                                                class="img-fluid w-100"></span>
                                        March 23, 2024
                                    </p>
                                    <a class="title" href="blog_details.html">The Best Delicious Coffee Shop In
                                        Bangkok
                                        China.</a>
                                </div>
                            </div>
                            <div class="popular_blog d-flex flex-wrap">
                                <div class="popular_blog_img">
                                    <img src="{{ url('assets/frontend/images/blog_img_2.png') }}" alt="img" class="img-fluid w-100">
                                </div>
                                <div class="popular_blog_text">
                                    <p>
                                        <span><img src="{{ url('assets/frontend/images/calender.png') }}" alt="icon"
                                                class="img-fluid w-100"></span>
                                        March 24, 2024
                                    </p>
                                    <a class="title" href="blog_details.html">Luxury top-floor properties
                                        available for
                                        purchase.</a>
                                </div>
                            </div>
                            <div class="popular_blog d-flex flex-wrap">
                                <div class="popular_blog_img">
                                    <img src="{{ url('assets/frontend/images/blog_img_3.png') }}" alt="img" class="img-fluid w-100">
                                </div>
                                <div class="popular_blog_text">
                                    <p>
                                        <span><img src="{{ url('assets/frontend/images/calender.png') }}" alt="icon"
                                                class="img-fluid w-100"></span>
                                        March 25, 2024
                                    </p>
                                    <a class="title" href="blog_details.html">Skills that you can learn the
                                        Real Estate
                                        Market.</a>
                                </div>
                            </div>
                        </div>
                        <div class="blog_details_right_header">
                            <h3>Property Categories</h3>
                            <ul class="sidebar_blog_category">
                                <li>
                                    <a href="#">
                                        <p>Make up</p>
                                        <span>(07)</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <p>Skin care</p>
                                        <span>(14)</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <p>Fashion and beauty</p>
                                        <span>(34)</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <p>Cosnetics</p>
                                        <span>(05)</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <p>Body care</p>
                                        <span>(18)</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="blog_details_right_header">
                            <h3>Popular Tags</h3>
                            <ul class="blog_details_tag d-flex flex-wrap">
                                <li><a href="#">Cleansing</a></li>
                                <li><a href="#">Make up</a></li>
                                <li><a href="#">eye cream</a></li>
                                <li><a href="#">nail</a></li>
                                <li><a href="#">shampoo</a></li>
                                <li><a href="#">coffee bean</a></li>
                                <li><a href="#">healthy</a></li>
                                <li><a href="#">skin care</a></li>
                                <li><a href="#">Cosmetics</a></li>
                            </ul>
                        </div>
                        <div class="blog_details_right_header">
                            <div class="blog_seidebar_add">
                                <img src="{{ url('assets/frontend/images/blog_sidebar_add_img.png') }}" alt="blog add"
                                    class="img-fluid w-100">
                                <div class="text">
                                    <h4>Will help enhance your beauty.</h4>
                                    <a class="common_btn" href="shop_details.html" tabindex="-1">shop now <i
                                            class="fas fa-long-arrow-right" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--============================
        BLOG RIGHT SIDEBAR START
    =============================-->
@endsection