@extends('frontend.layouts.app')

@section('content')

<!--=========================
    PAGE BANNER START
==========================-->
<livewire:frontend.components.page-banner :title="'Login'" />
<!--=========================
    PAGE BANNER END
==========================-->

<!--=========================
    LOGIN PAGE START
==========================-->
<livewire:frontend.auth.login />
<!--=========================
    LOGIN PAGE END
==========================-->

@endsection