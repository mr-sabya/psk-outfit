@extends('frontend.layouts.app')

@section('title')
    {{ $page->title }}
@endsection

@section('content')
<livewire:frontend.page.index pageId="{{ $page->id }}" />
@endsection