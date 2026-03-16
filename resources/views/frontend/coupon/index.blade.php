@extends('frontend.layouts.app')

@section('content')
<!--=========================
        PAGE BANNER START
    ==========================-->
<livewire:frontend.components.page-banner :title="'Coupons'" />
<!--=========================
        PAGE BANNER START
    ==========================-->


<!--=========================
        ABOUT US PAGE START
    ==========================-->
<livewire:frontend.coupon.index />


@endsection