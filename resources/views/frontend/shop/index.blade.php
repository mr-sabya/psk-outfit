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
                        <h1>Shop</h1>
                        <ul>
                            <li><a href="#"><i class="fal fa-home-lg"></i> Home</a></li>
                            <li><a href="#">Shop</a></li>
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
        SHOP PAGE START
    =============================-->
<livewire:frontend.shop.index />
<!--============================
        SHOP PAGE END
    =============================-->

@endsection