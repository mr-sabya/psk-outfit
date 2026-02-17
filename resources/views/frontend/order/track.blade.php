@extends('frontend.layouts.app')

@section('content')
<!--============================
        PAYMENT SUCCESS START
    =============================-->
<livewire:frontend.order.track :order_number="$order_number" />
<!--============================
        PAYMENT SUCCESS END
    =============================-->
@endsection