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
                        <h1>Register</h1>
                        <ul>
                            <li><a href="{{ route('home') }}"><i class="fal fa-home-lg"></i> Home</a></li>
                            <li><a href="#">Register</a></li>
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
    REGISTER PAGE START
==========================-->
<section class="login_area mt_100 mb_100">
    <div class="container">
        <div class="row">
            <div class="col-xxl-5 col-xl-6 col-lg-8 col-md-10 mx-auto wow fadeInUp">
                <div class="login_wrap">
                    <h3>Create A New Account</h3>
                    <p class="description">Welcome! Please register to continue.</p>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row">
                            {{-- Name --}}
                            <div class="col-12">
                                <div class="login_input_group">
                                    <label>Name</label>
                                    <input type="text" name="name" placeholder="Name" value="{{ old('name') }}" required autofocus>
                                    @error('name')
                                    <span class="text-danger mt-1 d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="col-12">
                                <div class="login_input_group">
                                    <label>Email Address</label>
                                    <input type="email" name="email" placeholder="example@gmail.com" value="{{ old('email') }}" required>
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

                            {{-- Confirm Password --}}
                            <div class="col-12">
                                <div class="login_input_group">
                                    <label>Confirm Password</label>
                                    <input type="password" name="password_confirmation" placeholder="********" required>
                                </div>
                            </div>

                            {{-- Terms & Conditions --}}
                            <div class="col-12">
                                <div class="login_options">
                                    {{-- Re-using the class we made for the login page --}}
                                    <div class="form-check custom-checkbox-container">
                                        <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                                        <label class="form-check-label" for="terms">
                                            I agree to the <a href="#">Terms & Policy</a>
                                        </label>
                                    </div>
                                    @error('terms')
                                    <span class="text-danger mt-1 d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Submit Button --}}
                            <div class="col-12">
                                <button type="submit" class="common_btn w-100">
                                    Sign Up <i class="fas fa-long-arrow-right"></i>
                                </button>
                            </div>

                            {{-- Login Link --}}
                            <div class="col-12">
                                <p class="create_account">
                                    Already have an account? <a href="{{ route('login') }}" wire:navigate>Login</a>
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
    REGISTER PAGE END
==========================-->

@endsection