@extends('frontend.layouts.app')

@section('content')

<!--=========================
    PAGE BANNER START
==========================-->
<livewire:frontend.components.page-banner :title="'Register'" />
<!--=========================
    PAGE BANNER END
==========================-->

<!--=========================
    REGISTER PAGE START
==========================-->
<livewire:frontend.auth.register />
<!--=========================
    REGISTER PAGE END
==========================-->

@endsection