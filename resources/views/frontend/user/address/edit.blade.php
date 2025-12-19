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
                        <h1>My Account</h1>
                        <ul>
                            <li><a href="#"><i class="fal fa-home-lg"></i> Home</a></li>
                            <li><a href="#">Overview</a></li>
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
        DSHBOARD START
    =============================-->
<section class="dashboard mb_100">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 wow fadeInUp">
                <livewire:frontend.user.sidebar />
            </div>
            <div class="col-lg-9 wow fadeInRight">
                <livewire:frontend.user.address-manage id="{{ $id }}" />
            </div>
        </div>
    </div>
</section>
<!--============================
        DSHBOARD END
    =============================-->
@endsection