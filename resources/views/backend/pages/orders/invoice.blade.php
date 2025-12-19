@extends('backend.layouts.app')

@section('content')
<livewire:backend.orders.invoice orderId="{{ $orderId }}" />
@endsection