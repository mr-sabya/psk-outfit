@extends('frontend.layouts.app')

@section('content')

<!--=========================
    PAGE BANNER START
==========================-->
<livewire:frontend.components.page-banner :title="'Reset Password'" />
<!--=========================
    PAGE BANNER END
==========================-->

<!--=========================
    LOGIN PAGE START
==========================-->
<livewire:frontend.auth.reset-password :token="$token" :email="$email" />
<!--=========================
    LOGIN PAGE END
==========================-->

@endsection