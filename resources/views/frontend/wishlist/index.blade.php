@extends('frontend.layouts.app')

@section('content')
<!--=========================
        PAGE BANNER START
    ==========================-->
<livewire:frontend.components.page-banner :title="'Wishlist'" />
<!--=========================
        PAGE BANNER START
    ==========================-->


<!--============================
        WISHLIST START
    =============================-->
<livewire:frontend.wishlist.index />
<!--============================
        WISHLIST END
    =============================-->
@endsection