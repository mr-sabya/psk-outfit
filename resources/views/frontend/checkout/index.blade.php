@extends('frontend.layouts.app')

@section('content')
<!--=========================
        PAGE BANNER START
    ==========================-->
<livewire:frontend.components.page-banner :title="'Checkout'" />
<!--=========================
        PAGE BANNER START
    ==========================-->


<!--============================
        CHECKOUT START
    =============================-->
<livewire:frontend.checkout.index />
<!--============================
        CHECKOUT END
    =============================-->
@endsection