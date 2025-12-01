@extends('backend.layouts.app')

@section('content')
<livewire:backend.collection.manage collectionId="{{ $collectionId }}" />
@endsection