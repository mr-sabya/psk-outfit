@extends('frontend.layouts.app')

@section('content')

<!--=========================
        PAGE BANNER START
    ==========================-->
<livewire:frontend.components.page-banner :title="'Categories'" />
<!--=========================
        PAGE BANNER START
    ==========================-->


<!--============================
        CATEGORY PAGE START
    =============================-->
<livewire:frontend.category.index />
<!--============================
        CATEGORY PAGE END
    =============================-->
@endsection