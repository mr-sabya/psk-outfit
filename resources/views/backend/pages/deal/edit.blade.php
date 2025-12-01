@extends('backend.layouts.app')

@section('content')
<livewire:backend.deal.manage dealId="{{ $dealId }}" />
@endsection