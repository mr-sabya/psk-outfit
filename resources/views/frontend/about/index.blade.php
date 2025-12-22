@extends('frontend.layouts.app')

@section('content')
<!--=========================
        PAGE BANNER START
    ==========================-->
<livewire:frontend.components.page-banner :title="'About Us'" />
<!--=========================
        PAGE BANNER START
    ==========================-->


<!--=========================
        ABOUT US PAGE START
    ==========================-->
<livewire:frontend.about.index />


<div class="mb-5">
    <livewire:frontend.home.blogs />
</div>
<!--=========================
        ABOUT US PAGE START
    ==========================-->

@endsection