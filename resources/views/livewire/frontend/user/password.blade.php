<div class="dashboard_content mt_100">
    <h3 class="dashboard_title">Change Password</h3>

    <div class="dashboard_change_password dashboard_profile_info_edit">

        @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <form wire:submit.prevent="updatePassword" class="info_edit_form">
            <div class="row">
                <!-- Current Password -->
                <div class="col-md-12">
                    <div class="single_input mb-3">
                        <label>Current Password</label>
                        <input type="password" wire:model="current_password" placeholder="**********">
                        @error('current_password')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- New Password -->
                <div class="col-md-6">
                    <div class="single_input mb-3">
                        <label>New Password</label>
                        <input type="password" wire:model="new_password" placeholder="**********">
                        @error('new_password')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="col-md-6">
                    <div class="single_input mb-3">
                        <label>Confirm Password</label>
                        <input type="password" wire:model="new_password_confirmation" placeholder="**********">
                    </div>
                </div>

                <div class="col-md-12">
                    <button type="submit" class="common_btn">
                        <span wire:loading.remove wire:target="updatePassword">
                            Submit <i class="fas fa-long-arrow-right"></i>
                        </span>
                        <span wire:loading wire:target="updatePassword">
                            Updating...
                        </span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>