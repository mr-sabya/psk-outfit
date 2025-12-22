@extends('frontend.layouts.app')

@section('content')
<!--=========================
        PAGE BANNER START
    ==========================-->
<livewire:frontend.components.page-banner :title="'Compare'" />
<!--=========================
        PAGE BANNER START
    ==========================-->


<!--============================
        COMPARE PAGE START
    =============================-->
<livewire:frontend.compare.index />
<!--============================
        COMPARE PAGE END
    =============================-->
@endsection