@extends('backend.layouts.app')

@section('content')

<livewire:backend.categories.manage categoryId="{{ $id }}" />

@endsection