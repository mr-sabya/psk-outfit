<section class="login_area mt_100 mb_100">
    <div class="container">
        <div class="row">
            <div class="col-xxl-5 col-xl-6 col-lg-8 col-md-10 mx-auto wow fadeInUp">
                <div class="login_wrap">
                    <h3>Create A New Account</h3>
                    <p class="description">Welcome! Please register to continue.</p>

                    <form wire:submit="register">
                        <div class="row">
                            {{-- Name --}}
                            <div class="col-12">
                                <div class="login_input_group">
                                    <label>Name</label>
                                    <input type="text"
                                        wire:model.blur="name"
                                        placeholder="Name"
                                        autofocus>
                                    @error('name')
                                    <span class="text-danger mt-1 d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="col-12">
                                <div class="login_input_group">
                                    <label>Email Address</label>
                                    <input type="email"
                                        wire:model.blur="email"
                                        placeholder="example@gmail.com">
                                    @error('email')
                                    <span class="text-danger mt-1 d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Password --}}
                            <div class="col-12">
                                <div class="login_input_group">
                                    <label>Password</label>
                                    <input type="password"
                                        wire:model.blur="password"
                                        placeholder="********">
                                    @error('password')
                                    <span class="text-danger mt-1 d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Confirm Password --}}
                            <div class="col-12">
                                <div class="login_input_group">
                                    <label>Confirm Password</label>
                                    <input type="password"
                                        wire:model.blur="password_confirmation"
                                        placeholder="********">
                                </div>
                            </div>

                            {{-- Terms & Conditions --}}
                            <div class="col-12">
                                <div class="login_options">
                                    <div class="form-check custom-checkbox-container">
                                        <input class="form-check-input"
                                            type="checkbox"
                                            wire:model="terms"
                                            id="terms">
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
                                <button type="submit" class="common_btn w-100" wire:loading.attr="disabled">

                                    {{-- Text to show normally --}}
                                    <span wire:loading.remove>
                                        Sign Up <i class="fas fa-long-arrow-right"></i>
                                    </span>

                                    {{-- Text/Spinner to show while processing --}}
                                    <span wire:loading>
                                        <i class="fas fa-spinner fa-spin"></i> Processing...
                                    </span>
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