@extends('backend.layouts.app')

@section('content')
<livewire:backend.investors.manage userId="{{ $userId }}" />
@endsection