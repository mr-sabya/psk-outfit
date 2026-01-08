@extends('frontend.layouts.app')

@section('content')

<!--=========================
    PAGE BANNER START
==========================-->
<livewire:frontend.components.page-banner :title="'Forgot Password'" />
<!--=========================
    PAGE BANNER END
==========================-->

<!--=========================
    LOGIN PAGE START
==========================-->
<livewire:frontend.auth.forgot-password />
<!--=========================
    LOGIN PAGE END
==========================-->

@endsection