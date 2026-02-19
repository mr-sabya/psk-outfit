@extends('frontend.layouts.app')

@section('content')

<!--=========================
        PAGE BANNER START
    ==========================-->
<livewire:frontend.components.page-banner :title="'Contact Us'" />
<!--=========================
        PAGE BANNER START
    ==========================-->


<!--============================
        CONTACT US START
    =============================-->
<livewire:frontend.contact.index />
<!--============================
        CONTACT US END
    =============================-->
@endsection