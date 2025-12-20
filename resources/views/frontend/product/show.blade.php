@extends('frontend.layouts.app')

@section('content')
<!--=========================
        PAGE BANNER START
    ==========================-->
<livewire:frontend.components.page-banner :title="'Product Details'" />
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