@extends('backend.layouts.app')

@section('content')
<livewire:backend.product.manage productId="{{ $product->id }}" />
@endsection