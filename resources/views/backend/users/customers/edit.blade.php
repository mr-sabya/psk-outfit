@extends('backend.layouts.app')

@section('content')
<livewire:backend.customers.manage userId="{{ $userId }}" />
@endsection