@extends('frontend.layouts.app')

@section('content')

<!--=========================
    PAGE BANNER START
==========================-->
<section class="page_banner" data-bg="{{ url('assets/frontend/images/page_banner_bg.jpg') }}">
    <div class="page_banner_overlay">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="page_banner_text wow fadeInUp">
                        <h1>Login</h1>
                        <ul>
                            <li><a href="{{ route('home') }}"><i class="fal fa-home-lg"></i> Home</a></li>
                            <li><a href="#">Login</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--=========================
    PAGE BANNER END
==========================-->

<!--=========================
    LOGIN PAGE START
==========================-->
<section class="login_area mt_100 mb_100">
    <div class="container">
        <div class="row">
            <div class="col-xxl-5 col-xl-6 col-lg-8 col-md-10 mx-auto wow fadeInUp">
                <div class="login_wrap">
                    <h3>Welcome Back!</h3>
                    <p class="description">Please sign in to access your account.</p>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row">
                            {{-- Email Address --}}
                            <div class="col-12">
                                <div class="login_input_group">
                                    <label>Email Address</label>
                                    <input type="email" name="email" placeholder="example@gmail.com" value="{{ old('email') }}" required autofocus>
                                    @error('email')
                                    <span class="text-danger mt-1 d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Password --}}
                            <div class="col-12">
                                <div class="login_input_group">
                                    <label>Password</label>
                                    <input type="password" name="password" placeholder="********" required>
                                    @error('password')
                                    <span class="text-danger mt-1 d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Remember Me & Forgot Password --}}
                            <div class="col-12">
                                <div class="login_options d-flex flex-wrap justify-content-between align-items-center">
                                    <div class="form-check custom-checkbox-container">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                                        <label class="form-check-label" for="remember_me">
                                            Remember me
                                        </label>
                                    </div>
                                    @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="forgot_link">Forgot Password?</a>
                                    @endif
                                </div>
                            </div>

                            {{-- Submit Button --}}
                            <div class="col-12">
                                <button type="submit" class="common_btn w-100">
                                    Login <i class="fas fa-long-arrow-right"></i>
                                </button>
                            </div>

                            {{-- Register Link --}}
                            <div class="col-12">
                                <p class="create_account">
                                    Don't have an account? <a href="{{ route('register') }}" wire:navigate>Create an account</a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--=========================
    LOGIN PAGE END
==========================-->

@endsection