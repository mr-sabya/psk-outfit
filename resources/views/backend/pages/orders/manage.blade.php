@extends('backend.layouts.app')

@section('content')
<livewire:backend.orders.manage orderId="{{ $order->id }}" />
@endsection