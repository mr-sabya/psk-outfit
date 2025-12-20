@extends('frontend.layouts.app')

@section('content')
<!--=========================
        PAGE BANNER START
    ==========================-->
<livewire:frontend.components.page-banner :title="'Dasboard'" />
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
            <div class="col-lg-9">
                <livewire:frontend.user.dashboard />
            </div>
        </div>
    </div>
</section>
<!--============================
        DSHBOARD END
    =============================-->
@endsection