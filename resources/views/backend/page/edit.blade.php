@extends('backend.layouts.app')

@section('content')
<livewire:backend.page.manage pageId="{{ $page->id }}" />
@endsection