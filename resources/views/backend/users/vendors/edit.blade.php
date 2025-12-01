@extends('backend.layouts.app')

@section('content')
<livewire:backend.vendors.manage userId="{{ $userId }}" />
@endsection