<section class="login_area mt_100 mb_100">
    <div class="container">
        <div class="row">
            <div class="col-xxl-5 col-xl-6 col-lg-8 col-md-10 mx-auto">
                <div class="login_wrap">
                    <h3>Set New Password</h3>
                    <p class="description">Please enter your new password below.</p>

                    <form wire:submit="resetPassword">
                        <div class="row">
                            <input type="hidden" wire:model="token">

                            {{-- Email (Read-only or Hidden usually, but required for validation) --}}
                            <div class="col-12">
                                <div class="login_input_group">
                                    <label>Email Address</label>
                                    <input type="email" wire:model="email" placeholder="example@gmail.com">
                                    @error('email') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            {{-- New Password --}}
                            <div class="col-12">
                                <div class="login_input_group">
                                    <label>New Password</label>
                                    <input type="password" wire:model="password" placeholder="********">
                                    @error('password') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            {{-- Confirm Password --}}
                            <div class="col-12">
                                <div class="login_input_group">
                                    <label>Confirm Password</label>
                                    <input type="password" wire:model="password_confirmation" placeholder="********">
                                </div>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="common_btn w-100" wire:loading.attr="disabled">
                                    <span wire:loading.remove>Update Password</span>
                                    <span wire:loading><i class="fas fa-spinner fa-spin"></i> Updating...</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>