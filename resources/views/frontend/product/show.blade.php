@extends('frontend.layouts.app')

@section('content')
<!--=========================
        PAGE BANNER START
    ==========================-->
<section class="page_banner" style="background: url(assets/images/page_banner_bg.jpg);">
    <div class="page_banner_overlay">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="page_banner_text wow fadeInUp">
                        <h1>Shop Details</h1>
                        <ul>
                            <li><a href="#"><i class="fal fa-home-lg"></i> Home</a></li>
                            <li><a href="#">Shop</a></li>
                            <li><a href="#">Shop Details</a></li>
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
        SHOP DETAILS START
    =============================-->
<livewire:frontend.product.show slug="{{ $product->slug }}" />
<!--============================
        SHOP DETAILS END
    =============================-->


<!--============================
        RELATED PRODUCTS START
    =============================-->
<section class="related_products mt_90 mb_70 wow fadeInUp">
    <div class="container">
        <div class="row">
            <div class="col-xl-6">
                <div class="section_heading_2 section_heading">
                    <h3><span>Related</span> Products</h3>
                </div>
            </div>
        </div>
        <div class="row mt_25 flash_sell_2_slider">
            <div class="col-xl-1-5">
                <div class="product_item_2 product_item">
                    <div class="product_img">
                        <img src="assets/images/product_1.png" alt="Product" class="img-fluid w-100">
                        <ul class="discount_list">
                            <li class="discount"> <b>-</b> 75%</li>
                            <li class="new"> new</li>
                        </ul>
                        <ul class="btn_list">
                            <li>
                                <a href="#">
                                    <img src="assets/images/compare_icon_white.svg" alt="Compare" class="img-fluid">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="assets/images/love_icon_white.svg" alt="Love" class="img-fluid">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="assets/images/cart_icon_white.svg" alt="Love" class="img-fluid">
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="product_text">
                        <a class="title" href="shop_details.html">Full Sleeve Hoodie Jacket</a>
                        <p class="price">$40.00 <del>$48.00</del></p>
                        <p class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                            <span>(20 reviews)</span>
                        </p>
                        <ul class="color">
                            <li class="active" style="background:#DB4437"></li>
                            <li style="background:#638C34"></li>
                            <li style="background:#1C58F2"></li>
                            <li style="background:#ffa500"></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-1-5">
                <div class="product_item_2 product_item">
                    <div class="product_img">
                        <img src="assets/images/product_24.png" alt="Product" class="img-fluid w-100">
                        <ul class="discount_list">
                            <li class="discount"> <b>-</b> 45%</li>
                        </ul>
                        <ul class="btn_list">
                            <li>
                                <a href="#">
                                    <img src="assets/images/compare_icon_white.svg" alt="Compare" class="img-fluid">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="assets/images/love_icon_white.svg" alt="Love" class="img-fluid">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="assets/images/cart_icon_white.svg" alt="Love" class="img-fluid">
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="product_text">
                        <a class="title" href="shop_details.html">Denim casual blazer for men</a>
                        <p class="price">$120.00 <del>$99.00</del></p>
                        <p class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <span>(17 reviews)</span>
                        </p>
                        <ul class="color">
                            <li class="active" style="background:#DB4437"></li>
                            <li style="background:#638C34"></li>
                            <li style="background:#ffa500"></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-1-5">
                <div class="product_item_2 product_item">
                    <div class="product_img">
                        <img src="assets/images/product_3.png" alt="Product" class="img-fluid w-100">
                        <ul class="discount_list">
                            <li class="discount"> <b>-</b> 15%</li>
                        </ul>
                        <ul class="btn_list">
                            <li>
                                <a href="#">
                                    <img src="assets/images/compare_icon_white.svg" alt="Compare" class="img-fluid">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="assets/images/love_icon_white.svg" alt="Love" class="img-fluid">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="assets/images/cart_icon_white.svg" alt="Love" class="img-fluid">
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="product_text">
                        <a class="title" href="shop_details.html">Women's Western Party Dress</a>
                        <p class="price">$50.00 <del>$40.00</del></p>
                        <p class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                            <span>(22 reviews)</span>
                        </p>
                        <ul class="color">
                            <li style="background:#638C34"></li>
                            <li style="background:#1C58F2"></li>
                            <li style="background:#ffa500"></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-1-5">
                <div class="product_item_2 product_item">
                    <div class="product_img">
                        <img src="assets/images/product_26.png" alt="Product" class="img-fluid w-100">
                        <ul class="discount_list">
                            <li class="discount"> <b>-</b> 75%</li>
                            <li class="new"> new</li>
                        </ul>
                        <ul class="btn_list">
                            <li>
                                <a href="#">
                                    <img src="assets/images/compare_icon_white.svg" alt="Compare" class="img-fluid">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="assets/images/love_icon_white.svg" alt="Love" class="img-fluid">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="assets/images/cart_icon_white.svg" alt="Love" class="img-fluid">
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="product_text">
                        <a class="title" href="shop_details.html">tops pant beautiful dress</a>
                        <p class="price">$75.00 <del>$69.00</del></p>
                        <p class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <i class="far fa-star"></i>
                            <span>(58 reviews)</span>
                        </p>
                        <ul class="color">
                            <li class="active" style="background:#DB4437"></li>
                            <li style="background:#638C34"></li>
                            <li style="background:#1C58F2"></li>
                            <li style="background:#ffa500"></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-1-5">
                <div class="product_item_2 product_item">
                    <div class="product_img">
                        <img src="assets/images/product_8.png" alt="Product" class="img-fluid w-100">
                        <ul class="discount_list">
                            <li class="discount"> <b>-</b> 49%</li>
                        </ul>
                        <ul class="btn_list">
                            <li>
                                <a href="#">
                                    <img src="assets/images/compare_icon_white.svg" alt="Compare" class="img-fluid">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="assets/images/love_icon_white.svg" alt="Love" class="img-fluid">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="assets/images/cart_icon_white.svg" alt="Love" class="img-fluid">
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="product_text">
                        <a class="title" href="shop_details.html">Kid's Western Party Dress</a>
                        <p class="price">$49.00 <del>$39.00</del></p>
                        <p class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <i class="far fa-star"></i>
                            <span>(44 reviews)</span>
                        </p>
                        <ul class="color">
                            <li class="active" style="background:#DB4437"></li>
                            <li style="background:#638C34"></li>
                            <li style="background:#1C58F2"></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-1-5">
                <div class="product_item_2 product_item">
                    <div class="product_img">
                        <img src="assets/images/product_19.png" alt="Product" class="img-fluid w-100">
                        <ul class="discount_list">
                            <li class="discount"> <b>-</b> 62%</li>
                        </ul>
                        <ul class="btn_list">
                            <li>
                                <a href="#">
                                    <img src="assets/images/compare_icon_white.svg" alt="Compare" class="img-fluid">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="assets/images/love_icon_white.svg" alt="Love" class="img-fluid">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="assets/images/cart_icon_white.svg" alt="Love" class="img-fluid">
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="product_text">
                        <a class="title" href="shop_details.html">Men's premium formal shirt</a>
                        <p class="price">$41.00 <del>$59.00</del></p>
                        <p class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <i class="far fa-star"></i>
                            <span>(98 reviews)</span>
                        </p>
                        <ul class="color">
                            <li class="active" style="background:#DB4437"></li>
                            <li style="background:#638C34"></li>
                            <li style="background:#1C58F2"></li>
                            <li style="background:#ffa500"></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--============================
        RELATED PRODUCTS END
    =============================-->
@endsection