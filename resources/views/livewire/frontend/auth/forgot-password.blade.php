<section class="login_area mt_100 mb_100">
    <div class="container">
        <div class="row">
            <div class="col-xxl-5 col-xl-6 col-lg-8 col-md-10 mx-auto">
                <div class="login_wrap">
                    <h3>Forgot Password?</h3>
                    <p class="description">Enter your email address and we'll send you a link to reset your password.</p>

                    @if ($status)
                    <div class="alert alert-success mb-4">
                        {{ $status }}
                    </div>
                    @endif

                    <form wire:submit="sendResetLink">
                        <div class="row">
                            <div class="col-12">
                                <div class="login_input_group">
                                    <label>Email Address</label>
                                    <input type="email" wire:model="email" placeholder="example@gmail.com">
                                    @error('email')
                                    <span class="text-danger mt-1 d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="common_btn w-100" wire:loading.attr="disabled">
                                    <span wire:loading.remove>Send Reset Link</span>
                                    <span wire:loading><i class="fas fa-spinner fa-spin"></i> Sending...</span>
                                </button>
                            </div>

                            <div class="col-12 mt-3 text-center">
                                <a href="{{ route('login') }}" wire:navigate class="forgot_link">Back to Login</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>