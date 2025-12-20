@extends('frontend.layouts.app')

@section('content')

<!--=========================
        PAGE BANNER START
    ==========================-->
<livewire:frontend.components.page-banner :title="'Blog'" />
<!--=========================
        PAGE BANNER START
    ==========================-->


<!--============================
        BLOG RIGHT SIDEBAR START
    =============================-->
<livewire:frontend.blog.show blogId="{{ $blog->id }}" />
<!--============================
        BLOG RIGHT SIDEBAR START
    =============================-->
@endsection