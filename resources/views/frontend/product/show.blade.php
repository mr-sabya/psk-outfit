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
<livewire:frontend.product.related-products productId="{{ $product->id }}" />
<!--============================
        RELATED PRODUCTS END
    =============================-->
@endsection