@extends('backend.layouts.app')

@section('content')
<livewire:backend.coupon.manage couponId="{{ $coupon->id }}" />
@endsection