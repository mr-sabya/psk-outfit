@extends('frontend.layouts.app')

@section('content')

<!--=========================
        PAGE BANNER START
    ==========================-->
<livewire:frontend.components.page-banner :title="'Flash Deals'" />
<!--=========================
        PAGE BANNER START
    ==========================-->


<!--============================
        FLASH DEALS START
    =============================-->
<livewire:frontend.flash-deal.index />
<!--============================
        FLASH DEALS END
    =============================-->
@endsection